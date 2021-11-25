<?php

namespace App\Controller;

use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/presentation', name: 'about')]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('about/index.html.twig', [
            'current_menu' => 'about',
            'workshops' => $workshopRepository->findAll()
        ]);
    }
}
