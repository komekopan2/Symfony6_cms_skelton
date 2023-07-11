<?php

namespace App\Controller\Mvc;

use App\Service\Sitemap\BuilderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: "/sitemap.xml")]
class SitemapXmlController extends AbstractController
{
    #[Route(path: "/", name: "sitemap_xml")]
    public function index(
        BuilderService $sitemap
    ): Response
    {
        $sitemap->registrationUrls();
        $xml = $sitemap->createXml();
        return $sitemap->response($xml);
    }
}