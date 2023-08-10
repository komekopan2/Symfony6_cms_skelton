<?php
namespace App\Controller\Mvc;

use App\Entity\VisitReservation\Inquiry;
use App\Event\VisitReservation\Inquiry\Send\PreMailSendEvent;
use App\Event\VisitReservation\Inquiry\Send\PostPersistEvent;
use App\Event\VisitReservation\Inquiry\Send\PostMailSendEvent;
use App\Form\VisitReservation\InquiryType;
use App\MailConfigure\VisitReservation\InquiryConfigure;
use App\Repository\VisitReservation\InquiryRepository;
use App\Service\InquiryControllerService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/visit-reservation")]
class VisitReservationController extends AbstractController
{
    private const SESSION_NAME = "visit-reservation";
    private const INDEX_TEMPLATE = "pages/visit-reservation/index.html.twig";
    private const INDEX_ROUTE = "visit-reservation_index";
    
    #[Route(
        path: "/",
        name: "visit-reservation_index",
        methods: ["GET"]
    )]
    public function index(
        Request $request,
        InquiryControllerService $service
    ): Response
    {
        $service->setContainer($this->container);
        $form = $service->prepareForm(
            $request,
            new Inquiry(),
            self::SESSION_NAME,
            InquiryType::class
        );
        return $this->render(self::INDEX_TEMPLATE, [
            "form" => $form->createView(),
            "retry" => false
        ]);
    }
    
    #[Route(
        path: "/confirm",
        name: "visit-reservation_confirm",
        methods: ["POST"]
    )]
    public function confirm(
        Request $request,
        InquiryControllerService $service,
        InquiryRepository $repository
    ): Response
    {
        $service->setContainer($this->container);
        
        $contact = new Inquiry();
        $form = $service->getSubmittedForm(
            $request,
            $contact,
            InquiryType::class
        );
        if(false === $service->formValidation($request, $contact, $form, $repository, false)) {
            return $this->render(self::INDEX_TEMPLATE, [
                "form" => $form->createView(),
                "retry" => true
            ]);
        }
        return $this->render("pages/visit-reservation/confirm.html.twig", [
            "inquiry" => $contact,
            "form" => $form->createView(),
            "confirmForm" => $service
                ->saveAndGetConfirmForm($request, $form, self::SESSION_NAME)
                ->createView()
        ]);
    }
    
    #[Route(
        path: "/send",
        name: "visit-reservation_send",
        methods: ["POST"]
    )]
    public function send(
        Request $request,
        InquiryControllerService $service,
        InquiryRepository $repository,
        InquiryConfigure $configure,
        EventDispatcherInterface $eventDispatcher
    ): Response
    {
        $service->setContainer($this->container);
        if(!$service->handleConfirmForm($request)) {
            return $this->redirectToRoute(self::INDEX_ROUTE);
        }
        $contact = new Inquiry();
        if(!$form = $service->loadAndGetForm(
            $request,
            $contact,
            InquiryType::class,
            self::SESSION_NAME
        )) {
            return $this->redirectToRoute(self::INDEX_ROUTE);
        }
        
        if(!$service->formValidation($request, $contact, $form, $repository)) {
            return $this->render(self::INDEX_TEMPLATE, [
                "form" => $service->createRetryForm(
                    InquiryType::class,
                    $contact,
                    $form
                )->createView(),
                "retry" => true
            ]);
        }
        
        $preEvent = new PreMailSendEvent($contact, $form);
        $eventDispatcher->dispatch($preEvent, PreMailSendEvent::EVENT_NAME);
        
        $sendSuccess = true;
        if(!$service->mailSend($configure, "client", $contact, $form)) {
            $sendSuccess = false;
        }
        if(!$service->mailSend($configure, "reply", $contact, $form)) {
            $sendSuccess = false;
        }
        if(false === $sendSuccess) {
            return $this->render(self::INDEX_TEMPLATE, [
                "form" => $service->createRetryForm(
                    InquiryType::class,
                    $contact,
                    "送信処理に失敗しました"
                )->createView(),
                "retry" => true
            ]);
        }
        $postSendEvent = new PostMailSendEvent($contact, $form);
        $eventDispatcher->dispatch($postSendEvent, PostMailSendEvent::EVENT_NAME);
        
        $repository->add($contact);
        
        $postEvent = new PostPersistEvent($contact, $form);
        $eventDispatcher->dispatch($postEvent, PostPersistEvent::EVENT_NAME);
        
        // pardot送信などの場合ここでHTMLレンダリング
        // return $this->render("pages/visit-reservation/send.html.twig", [
        //     "inquiry" => $contact
        // ]);
        
        return $this->redirectToRoute("visit-reservation_complete");
    }
    
    #[Route(
        path: "/complete",
        name: "visit-reservation_complete",
        methods: ["GET"]
    )]
    public function complete(
        Request $request
    ): Response
    {
        $request->getSession()->remove(self::SESSION_NAME);
        return $this->render("pages/visit-reservation/complete.html.twig", []);
    }
    
    #[Route(
        path: "/failure",
        name: "visit-reservation_failure",
        methods: ["GET"]
    )]
    public function failure(
        Request $request,
        InquiryControllerService $service,
        InquiryConfigure $configure
    ): Response
    {
        $service->setContainer($this->container);
        $contact = new Inquiry();
        if(!$form = $service->loadAndGetForm(
            $request,
            $contact,
            InquiryType::class,
            self::SESSION_NAME
        )) {
            return $this->redirectToRoute("visit-reservation_complete");
        }
        $service->mailSend($configure, "pardotFailure", $contact, $form);
        
        return $this->redirectToRoute("visit-reservation_complete");
    }
    
    #[Route(
        path: "/pardot_mock",
        name: "visit-reservation_pardot_mock",
        methods: ["POST"]
    )]
    public function pardotMock(
        Request $request,
        LoggerInterface $logger
    ): Response
    {
        $logger->info("見学予約 pardot send: ". print_r($request->request->all(), true));
        return $this->redirectToRoute("visit-reservation_failure");
    }
    
    #[Route(
        path: "/mock",
        name: "visit-reservation_mock",
        methods: ["GET"]
    )]
    public function mock(
        Request $request,
        InquiryControllerService $service
    ): Response
    {
        $service->setContainer($this->container);
        $contact = $service->createMock(Inquiry::class);
        $service->saveMock($request, $contact, InquiryType::class, self::SESSION_NAME);
        return $this->redirectToRoute(self::INDEX_ROUTE);
    }
}