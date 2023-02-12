<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\EventRepository;

class CartManager {

    private $eventRepository;
    private $session;

    public function __construct(EventRepository $eventRepository, SessionInterface $sessionInterface){
        $this->eventRepository = $eventRepository;
        $this->session = $sessionInterface;
    }

    public function getCart()
    {
        $cart = $this->session->get("panier", []);

        $dataCart = [];
        $total = 0;

        foreach($cart as $id => $quantity){
            $event = $this->eventRepository->findOneBy(['uid' => $id]);
            $dataCart[] = [
                "event" => $event,
                "quantity" => $quantity
            ];
            $total += $event->getWorkshop()->getWorkshopInfos()->getPrice() * $quantity;
        }

        return [
            'dataCart' => $dataCart, 
            'total' => $total
        ];
    }
}

