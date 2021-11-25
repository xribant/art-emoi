<?php

namespace App\Controller;

use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BooksController extends AbstractController
{
    #[Route('/publications', name: 'books')]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('books/index.html.twig', [
            'current_menu' => 'books',
            'workshops' => $workshopRepository->findAll()
        ]);
    }
}
