<?php
namespace App\Controller\Admin\VisitReservation;

use App\Entity\VisitReservation\Inquiry;
use App\Form\Admin\VisitReservation\InquirySearchType;
use App\Form\VisitReservation\InquiryType;
use App\Repository\VisitReservation\InquiryRepository;
use App\Utils\CsvExportProxy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TripleE\Utilities\Controller\IndexListTrait;

#[Route(path: "/admin/visit-reservation/inquiry")]
class InquiryController extends AbstractController
{
    use IndexListTrait;
    
    #[Route(
        path: "/{page}",
        name: "admin_visit-reservation_inquiry",
        requirements: ["page" => "\d+"],
        methods: ["GET", "POST"]
    )]
    public function index(
        Request $request,
        InquiryRepository $repository,
        int $page = 1
    ): Response
    {
        $form = $this->createForm(InquirySearchType::class);
        $paginate = $this->handleResumedList(
            $request,
            $form,
            $repository,
            "admin_visit-reservation_inquiry",
            $page
        );
        return $this->render("admin/visit-reservation/inquiry/index.html.twig", [
            "data" => $paginate->getPaginator()->getIterator(),
            "paginate" => $paginate,
            "form" => $form->createView(),
            "dataForm" => $this->createForm(InquiryType::class, new Inquiry())->createView()
        ]);
    }
    
    #[Route(
        path: "/csv",
        name: "admin_visit-reservation_inquiry_csv",
        methods: ["GET", "POST"]
    )]
    public function csv(
        Request $request,
        InquiryRepository $repository,
        CsvExportProxy $exportUtil
    ): Response
    {
        $form = $this->createForm(InquirySearchType::class);
        $query = $this->handleResumedList(
            $request,
            $form,
            $repository,
            "admin_visit-reservation_inquiry",
            1,
            null,
            true
        );
        return $exportUtil->getExporter()->entityCsvExport(
            $query,
            "見学予約.csv"
        );
    }
}