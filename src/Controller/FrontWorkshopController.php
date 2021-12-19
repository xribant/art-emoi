<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formation')]
class FrontWorkshopController extends AbstractController
{
    #[Route('/{slug}', name: 'front_workshop_infos')]
    public function index(WorkshopRepository $workshopRepository, EventRepository $eventRepository, $slug): Response
    {
        $workshop = $workshopRepository->findOneBy(['slug' => $slug]);

        return $this->render('front_workshop/index.html.twig', [
            'current_menu' => '',
            'events' => $eventRepository->findBy(['workshop' => $workshop]),
            'workshops' => $workshopRepository->findAll(),
            'workshop' => $workshop,
        ]);
    }

}
