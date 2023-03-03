<?php

namespace App\Service;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class InvoiceManager {

    private $invoiceRepository;
    private $em;
    private $twig;
    private $params;
    private $generator;

    public function __construct(InvoiceRepository $invoiceRepository, EntityManagerInterface $em, Environment $twig, PdfGenerator $generator, ContainerBagInterface $params, $stripeSK){
        $this->invoiceRepository = $invoiceRepository;
        $this->em = $em;
        $this->twig = $twig;
        $this->generator = $generator;
        $this->params = $params;
    }

    public function newInvoice($order, $session)
    {
        $newInvoice = new Invoice();

        $newInvoice->setFileName(uniqid().'.pdf')
            ->setLinkedOrder($order)
        ;

        // On récupère l'id de la dernière facture et on incrémente
        $newInvoiceId = $this->invoiceRepository->getLastInvoice()[0]->getId() + 1;
        $newInvoice->setId($newInvoiceId);

        $this->em->persist($newInvoice);
                    
        // Building the html file for PDF generator
        $html = $this->twig->render('documents/invoice.html.twig', [
            'title' => 'facture_'.date('Y').'-'.$newInvoiceId,
            'invoiceNum' => $newInvoiceId,
            'order' => $order,
            'unitPrice' => $order->getTotalAmount() - $order->getAmountTax(),
            'amountTax' => $order->getAmountTax(),
            'tvaRate' => $session->total_details->breakdown->taxes[0]->rate->percentage, 
            'totalAmount' => $order->getTotalAmount(),
        ]);

        $outputPath = $this->params->get('kernel.project_dir') . '/public/media/cache/invoices';

        $this->generator->createPDF($outputPath, $html, $newInvoice->getFileName());
        
        return $newInvoice;
        
    }
}