<?php

namespace App\Controller;

use App\Entity\EventRegistration;
use App\Entity\Invoice;
use App\Form\EventRegistrationType;
use App\Repository\EventRegistrationRepository;
use App\Repository\InvoiceRepository;
use App\Service\PdfGenerator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formation/inscription')]
class EventRegistrationController extends AbstractController
{
    #[Route('/', name: 'event_registration_index', methods: ['GET'])]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        return $this->render('admin/event_registration/index.html.twig', [
            'event_registrations' => $eventRegistrationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'event_registration_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $eventRegistration = new EventRegistration();
        $form = $this->createForm(EventRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setStatus('new');
            $eventRegistration->setUid(uniqid("",false).bin2hex(random_bytes(20)));
            $entityManager->persist($eventRegistration);
            $entityManager->flush();

            return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/event_registration/new.html.twig', [
            'event_registration' => $eventRegistration,
            'form' => $form,
        ]);
    }

    #[Route('/{uid}/edit', name: 'event_registration_edit', methods: ['GET','POST'])]
    public function edit(Request $request, EventRegistration $eventRegistration): Response
    {
        $form = $this->createForm(EventRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setUpdatedAt(new \DateTime('NOW'));
            $entityManager->persist($eventRegistration);
            $entityManager->flush();

            return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/event_registration/edit.html.twig', [
            'event_registration' => $eventRegistration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'event_registration_delete', methods: ['POST'])]
    public function delete(Request $request, EventRegistration $eventRegistration): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventRegistration->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventRegistration);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{uid}/confirmer', name: 'event_registration_confirm', methods: ['GET', 'POST'])]
    public function confirm(Request $request, EventRegistration $eventRegistration, PdfGenerator $generator, InvoiceRepository $invoiceRepository, MailerInterface $mailer): Response
    {
        $form = $this->createForm(EventRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setUpdatedAt(new \DateTime('NOW'));
            $eventRegistration->setStatus('paid');

            $invoice = new Invoice();

            if($invoiceRepository->findAll()) {
                $newInvoiceId = $invoiceRepository->findOneBy([], ['id' => 'desc'])->getId()+1;
            } else {
                $newInvoiceId = 1;
            }

            $invoiceNum = date('Y').'-'.$newInvoiceId;

            $invoice->setFileName('facture_'.$invoiceNum.'.pdf');
            $invoice->setNumber($invoiceNum);
            $invoice->setEventRegistration($eventRegistration);

            $entityManager->persist($eventRegistration);
            $entityManager->persist($invoice);
            $entityManager->flush();

            $html = $this->renderView('documents/invoice.html.twig', [
                'title' => 'facture_'.date('Y').'-'.$newInvoiceId,
                'registration' => $eventRegistration,
                'invoiceNum' => $invoiceNum
            ]);

            $outputPath = $this->getParameter('kernel.project_dir') . '/public/media/cache/invoices';

            $generator->createPDF($outputPath, $html, $invoice->getFileName());

            $email = (new TemplatedEmail())
                ->from('no-reply@art-emoi.be')
                ->to($eventRegistration->getEmail())
                ->cc('admin@art-emoi.be')
                ->subject('Art-Emoi : Confirmation d\'inscription et Facture')
                ->htmlTemplate('mails/invoice_confirmation.html.twig')
                ->attachFromPath($this->getParameter('kernel.project_dir') . '/public/media/cache/invoices/'.$invoice->getFileName(), $invoice->getFileName(), 'application/pdf')
                ->context([
                    'registration' => $eventRegistration,
                ])
            ;

            $mailer->send($email);

            return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/invoice/index.html.twig', [
            'event_registration' => $eventRegistration,
            'form' => $form
        ]);
    }

    #[Route('/{uid}/annuler', name: 'event_registration_cancel', methods: ['GET', 'POST'])]
    public function cancel(EventRegistration $eventRegistration): Response
    {
        $em = $this->getDoctrine()->getManager();
        $eventRegistration->setStatus('canceled');
        $em->persist($eventRegistration);
        $em->flush();

        return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
    }
}
