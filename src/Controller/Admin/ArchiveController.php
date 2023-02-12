<?php

namespace App\Controller\Admin;

use App\Repository\EventRegistrationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/inscription')]
class ArchiveController extends AbstractController
{
    #[Route('/archives', name: 'app_admin_archives')]
    public function index(EventRegistrationRepository $eventRegistrationRepository): Response
    {
        return $this->render('admin/event_registration/index_archived.html.twig', [
            'event_registrations' => $eventRegistrationRepository->findAllArchived(),
        ]);
    }

    #[Route('/send_to_archive?uid={uid}', name: 'app_admin_send_to_archive')]
    public function addToArchive(EventRegistrationRepository $eventRegistrationRepository, $uid): Response
    {
        $eventRegistration = $eventRegistrationRepository->findOneBy(['uid' => $uid]);
        $eventRegistration->setStatus('closed');
        $eventRegistration->setArchived(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($eventRegistration);
        $entityManager->flush();

        return $this->render('admin/event_registration/index.html.twig', [
            'event_registrations' => $eventRegistrationRepository->findAllNotArchived(),
        ]);
    }
}
