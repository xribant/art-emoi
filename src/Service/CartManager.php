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

            if($event->getPresent()){ 
                $price = $event->getProduct()->getPresentPrice();
            } else {
                $price = $event->getProduct()->getVisioPrice();
            }

            $dataCart[] = [
                "event" => $event,
                "quantity" => $quantity,
                "price" => $price
            ];
            $total += $price * $quantity;
        }

        return [
            'dataCart' => $dataCart, 
            'total' => $total
        ];
    }

    public function emptyCart() {
        $this->session->set("panier", []);
    }
}

