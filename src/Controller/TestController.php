<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('documents/test.html.twig', ['title' => 'Facture 2021-003']);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $cachePath = $this->getParameter('kernel.project_dir') . '/var/cache/dev';

        if(is_dir($cachePath . '/invoices')) {
            $pdfFilepath =  $cachePath . '/invoices/Facture 2021-003.pdf';
            file_put_contents($pdfFilepath, $output);
        }
        else {
            mkdir($cachePath . '/invoices');
            $pdfFilepath =  $cachePath . '/invoices/Facture 2021-003.pdf';
            file_put_contents($pdfFilepath, $output);
        }

        return $this->redirectToRoute('home');

    }
}
