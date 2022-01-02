<?php

namespace App\Controller;

use App\Form\InvoiceConfirmationDataType;
use App\Repository\EventRegistrationRepository;
use App\Service\PdfGenerator;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvoiceConfirmationController extends AbstractController
{
    #[Route('/facturation/inscription={uid}', name: 'invoice_confirmation')]
    public function index($uid, EventRegistrationRepository $eventRegistrationRepository, Request $request, PdfGenerator $generator): Response
    {
        $registration = $eventRegistrationRepository->findOneBy(['uid' => $uid]);

        $form = $this->createForm(InvoiceConfirmationDataType::class, $registration);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $html = $this->renderView('documents/test.html.twig', ['title' => 'Facture 2021-003']);
            $outputPath = $this->getParameter('kernel.project_dir') . '/var/cache/dev';
            $generator->createInvoice($outputPath, $html);
            $registration->setStatus('paid');

            $entityManager->persist($registration);
            $entityManager->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/invoice_confirmation/index.html.twig', [
            'registration' => $registration,
            'form' => $form->createView()
        ]);
    }
}
