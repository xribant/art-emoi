<?php

namespace App\Controller\Admin;

use App\Repository\EventRegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        return $this->render('admin/event_registration/index.html.twig', [
            'event_registrations' => $eventRegistrationRepository->findAll()
        ]);
    }
}
