<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use App\Repository\NewsRepository;
use App\Repository\ProductRepository;
use App\Service\CartManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(NewsRepository $newsRepository, ProductRepository $productRepository, CartManager $cartManager, ActuRepository $actuRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'news' => $newsRepository->findAll(),
            'products' => $productRepository->findAll(),
            'cart' => $cartManager->getCart(),
            'actuItems' => $actuRepository->findAll()
        ]);
    }
}
