<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use App\Repository\PartnersRepository;
use App\Repository\WorkshopRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontActuController extends AbstractController
{
    #[Route('/evenements/{slug}', name: 'front_actu')]
    public function index(WorkshopRepository $workshopRepository, PartnersRepository $partnersRepository, CartManager $cartManager, ActuRepository $actuRepository, $slug): Response
    {
        $cart = $cartManager->getCart();

        $actu = $actuRepository->findOneBy(['slug' => $slug]);

        return $this->render('front_actu/index.html.twig', [
            'current_menu' => 'partners',
            'workshops' => $workshopRepository->findAll(),
            'partners' => $partnersRepository->findAll(),
            'cart' => $cart,
            'actuItems' => $actuRepository->findAll(),
            'actu' => $actu
        ]);
    }
}
