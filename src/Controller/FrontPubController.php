<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPubController extends AbstractController
{
    #[Route('/evenements', name: 'app_pub')]
    public function index(): Response
    {
        return $this->render('pub/index.html.twig', [
            'current_menu' => 'event',
        ]);
    }
}
