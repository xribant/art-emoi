<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    #[Route('/agenda', name: 'agenda')]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('agenda/index.html.twig', [
            'current_menu' => 'agenda',
            'events' => $eventRepository->findAllFuture()
        ]);
    }

    #[Route('/agenda/{slug}/{location}', name: 'agenda_by_workshop')]
    public function showByWorkshop(EventRepository $eventRepository, WorkshopRepository $workshopRepository, $slug, $location): Response
    {
        if($location == 'zoom') {
            $events = $eventRepository->findOnlyFutureByWorkshopAndZoom($workshopRepository->findOneBy(['slug' => $slug]));
        } else {
            $events = $eventRepository->findOnlyFutureByWorkshopAndPresentiel($workshopRepository->findOneBy(['slug' => $slug]));
        }

        return $this->render('agenda/index.html.twig', [
            'current_menu' => 'agenda',
            'events' => $events
        ]);
    }
}
