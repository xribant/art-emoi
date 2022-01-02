<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PDFController extends AbstractController
{
    #[Route('/admin/pdf', name: 'generate_pdf')]
    public function index(): Response {

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

        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

        return $this->redirectToRoute('home');
    }

}
