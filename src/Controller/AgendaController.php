<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\WorkshopRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    #[Route('/agenda', name: 'agenda')]
    public function index(EventRepository $eventRepository, CartManager $cartManager): Response
    {
        $cart = $cartManager->getCart();

        return $this->render('agenda/index.html.twig', [
            'current_menu' => 'agenda',
            'events' => $eventRepository->findAllFuture(),
            'cart' => $cart
        ]);
    }

    #[Route('/agenda/{slug}/{location}', name: 'agenda_by_workshop')]
    public function showByWorkshop(EventRepository $eventRepository, WorkshopRepository $workshopRepository, CartManager $cartManager, $slug, $location): Response
    {
        $cart = $cartManager->getCart();

        if($location == 'zoom') {
            $events = $eventRepository->findOnlyFutureByWorkshopAndZoom($workshopRepository->findOneBy(['slug' => $slug]));
        } else {
            $events = $eventRepository->findOnlyFutureByWorkshopAndPresentiel($workshopRepository->findOneBy(['slug' => $slug]));
        }

        return $this->render('agenda/index.html.twig', [
            'current_menu' => 'agenda',
            'events' => $events,
            'cart' => $cart
        ]);
    }
}
