<?php

namespace App\Controller;

use App\Entity\EventRegistration;
use App\Entity\Invoice;
use App\Form\ConfirmRegistrationType;
use App\Form\EventRegistrationType;
use App\Repository\EventRegistrationRepository;
use App\Repository\EventRepository;
use App\Repository\InvoiceRepository;
use App\Service\PdfGenerator;
use Flasher\Toastr\Prime\ToastrFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formation/inscription')]
class EventRegistrationController extends AbstractController
{
    #[Route('/', name: 'event_registration_index', methods: ['GET'])]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        return $this->render('admin/event_registration/index.html.twig', [
            'event_registrations' => $eventRegistrationRepository->findAllNotArchived(),
        ]);
    }

    #[Route('/new', name: 'event_registration_new', methods: ['GET','POST'])]
    public function new(Request $request, MailerInterface $mailer, ToastrFactory $toastr): Response
    {
        $eventRegistration = new EventRegistration();
        $form = $this->createForm(EventRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from('admin@art-emoi.be')
                    // ->to('xribant@gmail.com')
                ->to(new Address($eventRegistration->getEmail()))
                ->cc('admin@art-emoi.be')
                ->subject('Art-Emoi : Demande d\'inscription')
                ->htmlTemplate('mails/registration_confirmation.html.twig')
                ->context([
                    'registration' => $eventRegistration,
                ])
            ;

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $toastr
                    ->warning("Inscription invalide. L'adresse e-mail introduite à l'inscription n'existe pas !!!")
                    ->timeOut(10000)
                    ->progressBar()
                    ->closeButton()
                    ->positionClass('toast-top-left')
                    ->flash()
                ;

                return $this->redirectToRoute('event_registration_index');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setStatus('new');
            $eventRegistration->setArchived(false);
            $eventRegistration->setUid(uniqid());
            $entityManager->persist($eventRegistration);
            $entityManager->flush();

            $toastr
                ->success('<strong>Inscription enregistrée! <br>Un e-mail de confirmation a été envoyé à l\'utilisateur avec les instructions.</strong>')
                ->timeOut(5000)
                ->progressBar()
                ->closeButton()
                ->positionClass('toast-top-left')
                ->flash()
            ;

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
        $event = $eventRegistration->getEvent();

        $form = $this->createForm(ConfirmRegistrationType::class, $eventRegistration, ['event' => $event]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setUpdatedAt(new \DateTime('NOW'));
            $eventRegistration->setStatus('invoiced');

            $invoice = new Invoice();

            if($invoiceRepository->findAll()) {
                $newInvoiceId = $invoiceRepository->findOneBy([], ['id' => 'desc'])->getId()+1;
            } else {
                $newInvoiceId = 1;
            }

            $invoiceNum = $newInvoiceId;

            $invoice->setFileName(uniqid().'.pdf');
            $invoice->setNumber($invoiceNum);
            $invoice->setEventRegistration($eventRegistration);

            $entityManager->persist($eventRegistration);
            $entityManager->persist($invoice);
            $entityManager->flush();

            $invoicePrice = $form['price']->getData();
            $invoiceTvaRate = $form['tvaRate']->getData();
            $invoiceTotalTva = $form['totalTVA']->getData();
            $invoicePriceHTVA = $form['totalHTVA']->getData();

            $html = $this->renderView('documents/invoice.html.twig', [
                'title' => 'facture_'.date('Y').'-'.$newInvoiceId,
                'registration' => $eventRegistration,
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
                 ->to($eventRegistration->getEmail())
                ->cc('admin@art-emoi.be')
                // ->to('xribant@gmail.com')
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
