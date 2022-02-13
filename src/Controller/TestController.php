<?php

namespace App\Controller;

use App\Repository\EventRegistrationRepository;
use App\Service\ExcelExport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        $registration = $eventRegistrationRepository->findOneBy(['id' => 33]);

        return $this->render('documents/invoice.html.twig', [
            'title' => 'facture_'.date('Y').'-',
            'registration' => $registration,
            'invoiceNum' => 203,
            'price' => 150,
            'tvaRate' => 21,
            'totalTva' => 140,
            'priceHTVA' => 10
        ]);
    }
}
