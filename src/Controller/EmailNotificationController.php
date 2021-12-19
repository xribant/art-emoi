<?php

namespace App\Controller;

use App\Entity\EmailNotification;
use App\Form\EmailNotificationType;
use App\Repository\EmailNotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/notifications')]
class EmailNotificationController extends AbstractController
{
    #[Route('/', name: 'email_notification_index', methods: ['GET'])]
    public function index(EmailNotificationRepository $emailNotificationRepository): Response
    {
        return $this->render('admin/email_notification/index.html.twig', [
            'notifications' => $emailNotificationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'email_notification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $emailNotification = new EmailNotification();
        $form = $this->createForm(EmailNotificationType::class, $emailNotification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $emailNotification->setUpatedAt(new \DateTime());
            $entityManager->persist($emailNotification);
            $entityManager->flush();

            return $this->redirectToRoute('email_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/email_notification/new.html.twig', [
            'notification' => $emailNotification,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/edit', name: 'email_notification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EmailNotification $emailNotification, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmailNotificationType::class, $emailNotification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('email_notification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/email_notification/edit.html.twig', [
            'notification' => $emailNotification,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'email_notification_delete', methods: ['POST'])]
    public function delete(Request $request, EmailNotification $emailNotification, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$emailNotification->getSlug(), $request->request->get('_token'))) {
            $entityManager->remove($emailNotification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('email_notification_index', [], Response::HTTP_SEE_OTHER);
    }
}
