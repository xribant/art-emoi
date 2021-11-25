<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/*
 * @Route("/formation")
 */
class FrontWorkshopController extends AbstractController
{
    #[Route('/carnet-de-deuil', name: 'front_workshop_deuil')]
    public function deuil(WorkshopRepository $workshopRepository, EventRepository $eventRepository): Response
    {
        return $this->render('front_workshop/deuil.html.twig', [
            'current_menu' => '',
            'workshops' => $workshopRepository->findAll(),
            'events' => $eventRepository->findAll()
        ]);
    }

    #[Route('/tarot-creatif', name: 'front_workshop_tarot')]
    public function tarot(): Response
    {
        return $this->render('front_workshop/tarot.html.twig');
    }
    #[Route('/burnout', name: 'front_workshop_burnout')]
    public function burnout(): Response
    {
        return $this->render('front_workshop/tarot.html.twig');
    }
    #[Route('/accompagnement-individuel', name: 'front_workshop_accompagnement')]
    public function accompagnement(): Response
    {
        return $this->render('front_workshop/accompagnement.html.twig');
    }
}
