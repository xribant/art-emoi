<?php

namespace App\Controller\Admin;

use App\Entity\FreeRegistration;
use App\Entity\Invoice;
use App\Form\FreeRegistrationType;
use App\Repository\FreeRegistrationRepository;
use App\Repository\InvoiceRepository;
use App\Service\PdfGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/facture-libre')]
class FreeRegistrationController extends AbstractController
{
    #[Route('/', name: 'free_registration_index', methods: ['GET'])]
    public function index(FreeRegistrationRepository $freeRegistrationRepository): Response
    {
        return $this->render('admin/free_registration/index.html.twig', [
            'free_registrations' => $freeRegistrationRepository->findAll(),
            'active_menu' => 'free_invoicing'
        ]);
    }

    #[Route('/nouvelle', name: 'free_registration_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, InvoiceRepository $invoiceRepository, PdfGenerator $generator, MailerInterface $mailer): Response
    {
        $freeRegistration = new FreeRegistration();
        $form = $this->createForm(FreeRegistrationType::class, $freeRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $invoice = new Invoice();

            if($invoiceRepository->findAll()) {
                $newInvoiceId = $invoiceRepository->findOneBy([], ['id' => 'desc'])->getId()+1;
            } else {
                $newInvoiceId = 1;
            }

            $invoiceNum = $newInvoiceId;

            $invoice->setFileName(uniqid().'.pdf');
            $invoice->setNumber($invoiceNum);

            $freeRegistration->setInvoice($invoice);
            $entityManager->persist($freeRegistration);
            $entityManager->persist($invoice);
            $entityManager->flush();

            $invoicePrice = $form['price']->getData();
            $invoiceTvaRate = $form['tvaRate']->getData();
            $invoiceTotalTva = $form['totalTVA']->getData();
            $invoicePriceHTVA = $form['totalHTVA']->getData();

            $html = $this->renderView('documents/free_invoice.html.twig', [
                'title' => 'facture_'.date('Y').'-'.$newInvoiceId,
                'registration' => $freeRegistration,
                'invoiceNum' => $invoiceNum,
                'price' => $invoicePrice,
                'tvaRate' => $invoiceTvaRate,
                'totalTva' => $invoiceTotalTva,
                'priceHTVA' => $invoicePriceHTVA
            ]);

            $outputPath = $this->getParameter('kernel.project_dir') . '/public/media/cache/invoices';

            $generator->createPDF($outputPath, $html, $invoice->getFileName());

            $email = (new TemplatedEmail())
                ->from('no-reply@art-emoi.be')
                // ->to('xribant@gmail.com')
                ->to($freeRegistration->getEmail())
                ->cc('admin@art-emoi.be')
                ->subject('Art-Emoi : Facture n° '.$invoiceNum)
                ->htmlTemplate('mails/free_invoice_confirmation.html.twig')
                ->attachFromPath($this->getParameter('kernel.project_dir') . '/public/media/cache/invoices/'.$invoice->getFileName(), $invoice->getFileName(), 'application/pdf')
                ->context([
                    'registration' => $freeRegistration,
                ])
            ;

            $mailer->send($email);

            return $this->redirectToRoute('free_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/free_registration/new.html.twig', [
            'free_registration' => $freeRegistration,
            'form' => $form,
            'active_menu' => 'free_invoicing'
        ]);
    }


    #[Route('/{id}', name: 'free_registration_delete', methods: ['POST'])]
    public function delete(Request $request, FreeRegistration $freeRegistration, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$freeRegistration->getId(), $request->request->get('_token'))) {
            $entityManager->remove($freeRegistration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('free_registration_index', [], Response::HTTP_SEE_OTHER);
    }
}
