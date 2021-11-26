<?php

namespace App\Controller;

use App\Entity\EventRegistration;
use App\Form\EventRegistrationType;
use App\Repository\EventRegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/formation/inscription')]
class EventRegistrationController extends AbstractController
{
    #[Route('/', name: 'event_registration_index', methods: ['GET'])]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        return $this->render('event_registration/index.html.twig', [
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
            $entityManager->persist($eventRegistration);
            $entityManager->flush();

            return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_registration/new.html.twig', [
            'event_registration' => $eventRegistration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'event_registration_show', methods: ['GET'])]
    public function show(EventRegistration $eventRegistration): Response
    {
        return $this->render('event_registration/show.html.twig', [
            'event_registration' => $eventRegistration,
        ]);
    }

    #[Route('/{id}/edit', name: 'event_registration_edit', methods: ['GET','POST'])]
    public function edit(Request $request, EventRegistration $eventRegistration): Response
    {
        $form = $this->createForm(EventRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_registration_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event_registration/edit.html.twig', [
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
}
