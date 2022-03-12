<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontBooksController extends AbstractController
{
    #[Route('/publications', name: 'books')]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('books/index.html.twig', [
            'current_menu' => 'books',
            'books' => $bookRepository->findAll()
        ]);
    }
}
