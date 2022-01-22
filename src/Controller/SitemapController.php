<?php

namespace App\Controller;

use App\Entity\Workshop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route("/sitemap.xml", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(Request $request): Response
    {
        $hostname = $request->getSchemeAndHttpHost();

        $urls = [];

        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('about')];
        $urls[] = ['loc' => $this->generateUrl('front_partners')];
        $urls[] = ['loc' => $this->generateUrl('books')];
        $urls[] = ['loc' => $this->generateUrl('contact_form')];

        foreach($this->getDoctrine()->getRepository(Workshop::class)->findAll() as $workshop) {

            $images = [
                'loc' => '/media/cache/worshop_jacket/'.$workshop->getImageName(),
                'title' => $workshop->getTitle()
            ];

            $urls[] = [
                'loc' => $this->generateUrl('front_workshop_infos', ['slug' => $workshop->getSlug()]),
                'image' => $images,
                'lastmod' => $workshop->getUpdatedAt()->format('Y-m-d'),
            ];
        }

        $response = new Response(
            $this->renderView('sitemap/index.html.twig', [
                'urls' => $urls,
                'hostname' => $hostname
            ]),
            200
        );

        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
