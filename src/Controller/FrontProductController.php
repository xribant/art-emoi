<?php

namespace App\Controller;

use App\Repository\ActuRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ateliers-et-formations')]
class FrontProductController extends AbstractController
{
    #[Route('/{slug}', name: 'front_product_details')]
    public function index(ProductRepository $productRepository, $slug, ActuRepository $actuRepository): Response
    {
        $product = $productRepository->findOneBy(['slug' => $slug]);

        return $this->render('front_workshop/index.html.twig', [
            'current_menu' => '',
            'product' => $product,
            'actuItems' => $actuRepository->findAll()
        ]);
    }

}
