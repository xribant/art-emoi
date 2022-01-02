<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use Twig\Environment;

class PdfGenerator
{
    private $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    public function createInvoice($outputPath, $html) {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isHtml5ParserEnabled', true);
        $pdfOptions->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($pdfOptions);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // Check if the invoices cache folder exist before to create the file
        if(is_dir($outputPath . '/invoices')) {
            $pdfFilepath =  $outputPath . '/invoices/Facture 2021-003.pdf';
            file_put_contents($pdfFilepath, $output);
        }
        else {
            mkdir($outputPath . '/invoices');
            $pdfFilepath =  $outputPath . '/invoices/Facture 2021-003.pdf';
            file_put_contents($pdfFilepath, $output);
        }

        return "";

    }
}
