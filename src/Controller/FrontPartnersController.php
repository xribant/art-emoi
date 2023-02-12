<?php

namespace App\Controller;

use App\Repository\PartnersRepository;
use App\Repository\WorkshopRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPartnersController extends AbstractController
{
    #[Route('/partenaires', name: 'front_partners')]
    public function index(WorkshopRepository $workshopRepository, PartnersRepository $partnersRepository, CartManager $cartManager): Response
    {
        $cart = $cartManager->getCart();

        return $this->render('partners/index.html.twig', [
            'current_menu' => 'partners',
            'workshops' => $workshopRepository->findAll(),
            'partners' => $partnersRepository->findAll(),
            'cart' => $cart
        ]);
    }
}
