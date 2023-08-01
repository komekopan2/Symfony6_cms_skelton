<?php

namespace App\Controller\Admin;

use App\Entity\Topics\Post;
use App\Form\Admin\Topics\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Topics\PostRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route("/admin/topics")]
class TopicsController extends AbstractController
{
    #[Route("/", name: "admin_topics_index", methods: ["GET"])]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render("admin/topics/index.html.twig", [
            "posts" => $postRepository->findBy([], ["postAt" => "desc"])
        ]);
    }

    #[Route("/add", name: "admin_topics_add", methods: ["GET", "POST"])]
    public function add(
        Request $request,
        PostRepository $postRepository
    ): Response {
        $post = (new Post())
            ->setPostAt(new \DateTime());
        $form = $this->createForm(PostType::class, $post);
        if ("POST" === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $postRepository->save($post, true);
                $this->addFlash("success", "保存しました");
                return $this->redirectToRoute("admin_topics_index");
            }
            $this->addFlash("error", "入力内容に不備がありました");
        }

        return $this->render("admin/topics/form.html.twig", [
            "form" => $form->createView(),
            "isCreate" => true
        ]);
    }
    #[Route("/edit/{id}", name: "admin_topics_edit", requirements: ["id" => "\d"], methods: ["GET", "POST"])]
    public function edit(
        Request $request,
        PostRepository $postRepository,
        Post $post
    ): Response {
        $form = $this->createForm(PostType::class, $post);
        if ("POST" === $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $postRepository->save($post, true);
                $this->addFlash("success", "保存しました");
                return $this->redirectToRoute("admin_topics_index");
            }
            $this->addFlash("error", "入力内容に不備がありました");
        }

        return $this->render("admin/topics/form.html.twig", [
            "form" => $form->createView(),
            "isCreate" => false
        ]);
    }

    #[Route("/delete/{id}", name: "admin_topics_delete", requirements: ["id" => "\d"], methods: ["DELETE", "POST"])]
    public function delete(
        Request $request,
        PostRepository $postRepository,
        Post $post
    ): Response {
        if ($this->isCsrfTokenValid(
            "admin_topics_delete_" . $post->getId(),
            $request->request->get('_token')
        )) {
            $postRepository->remove($post, true);
            $this->addFlash("success", "削除しました");
        }
        return $this->redirectToRoute("admin_topics_index");
    }
}
