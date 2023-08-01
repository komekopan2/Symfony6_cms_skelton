<?php

/**
 * TOPページ
 */

namespace App\Controller\Mvc;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Topics\PostRepository;

class IndexController extends AbstractController
{
    #[Route(path: '/', name: 'top')]
    public function index(
        PostRepository $postRepository
    ): Response {
        return $this->render('pages/index/index.html.twig', [
            "topics" => $postRepository->getPosts()
        ]);
    }
}
