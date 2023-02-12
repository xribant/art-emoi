<?php

namespace App\Controller;

use App\Repository\WorkshopRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AboutController extends AbstractController
{
    #[Route('/presentation', name: 'about')]
    public function index(WorkshopRepository $workshopRepository, SessionInterface $session, CartManager $cartManager): Response
    {
        $cart = $cartManager->getCart();

        return $this->render('about/index.html.twig', [
            'current_menu' => 'about',
            'workshops' => $workshopRepository->findAll(),
            'cart' => $cart
        ]);
    }
}
