<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Repository\EventRegistrationRepository;
use App\Repository\InvoiceRepository;
use App\Service\PdfGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceController extends AbstractController
{
    #[Route('/admin/invoice', name: 'invoice')]
    public function index(): Response
    {
        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }

    #[Route('/admin/invoice/new/{registration_uid}', name: 'invoice_new')]
    public function new($registration_uid, EventRegistrationRepository $eventRegistrationRepository, InvoiceRepository $invoiceRepository, PdfGenerator $pdfGenerator): Response
    {
        $registration = $eventRegistrationRepository->findOneBy(['uid' => $registration_uid]);

        // On récupère l'id de la dernière facture enregistrée

        $lastInvoice = $invoiceRepository->findOneBy([], ['id' => 'DESC']);

        // On crée le fichier pdf

        $outputPath = $this->getParameter('kernel.project_dir') . '/public/media/cache/invoices';

        if($lastInvoice) {
            $invoiceName = 'facture-'.date("Y").'-'.($lastInvoice->getId()+1).'.pdf';
        } else {
            $invoiceName = 'facture-'.date("Y").'-001.pdf';
        }

        $html = $this->renderView('documents/invoice.html.twig', [
            'title' => $invoiceName,
            'registration' => $registration
        ]);

        $pdfGenerator->createPDF($outputPath, $html, $invoiceName);

        // On insère la nouvelle entité invoice dans la base de donnée

        $invoice = new Invoice();

        $invoice->setCreatedAt(new \DateTime());
        $invoice->setEventRegistration($registration);
        $invoice->setName($invoiceName);
        $invoice->setFileName($invoiceName.'.pdf');

        $em = $this->getDoctrine()->getManager();
        $em->persist($invoice);
        $em->flush();

        return $this->redirectToRoute('admin');
    }
}
