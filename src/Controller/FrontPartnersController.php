<?php

namespace App\Controller;

use App\Repository\PartnersRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPartnersController extends AbstractController
{
    #[Route('/partenaires', name: 'front_partners')]
    public function index(WorkshopRepository $workshopRepository, PartnersRepository $partnersRepository): Response
    {
        return $this->render('partners/index.html.twig', [
            'current_menu' => 'partners',
            'workshops' => $workshopRepository->findAll(),
            'partners' => $partnersRepository->findAll()
        ]);
    }
}
