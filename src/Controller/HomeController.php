<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(NewsRepository $newsRepository, WorkshopRepository $workshopRepository, EventRepository $eventRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'current_menu' => 'home',
            'news' => $newsRepository->findAll(),
            'workshops' => $workshopRepository->findAll()
        ]);
    }
}
