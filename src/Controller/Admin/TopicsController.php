<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Topics\PostRepository;

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
    #[Route("/add", name: "admin_topics_add", methods: ["GET"])]
    public function add(): Response
    {
        return $this->render("admin/topics/form.html.twig", []);
    }
}
