<?php

namespace App\Controller\Admin;

use App\Entity\WorkshopVideo;
use App\Form\WorkshopVideoType;
use App\Repository\WorkshopRepository;
use App\Repository\WorkshopVideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/workshop/{workshop_slug}/video')]
class WorkshopVideoController extends AbstractController
{
    #[Route('/', name: 'workshop_video_index', methods: ['GET'])]
    public function index(WorkshopVideoRepository $workshopVideoRepository): Response
    {
        return $this->render('admin/workshop/video/index.html.twig', [
            'workshop_videos' => $workshopVideoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'workshop_video_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, WorkshopRepository $workshopRepository, $workshop_slug): Response
    {
        $workshopVideo = new WorkshopVideo();
        $form = $this->createForm(WorkshopVideoType::class, $workshopVideo);
        $form->handleRequest($request);
        $workshop = $workshopRepository->findOneBy(['slug' => $workshop_slug]);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopVideo->setWorkshop($workshop);
            $entityManager->persist($workshopVideo);
            $entityManager->flush();

            return $this->redirectToRoute('workshop_edit', ['slug' => $workshop->getSlug() ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/video/new.html.twig', [
            'workshop_video' => $workshopVideo,
            'form' => $form,
            'workshop' => $workshop
        ]);
    }

    #[Route('/{slug}/edit', name: 'workshop_video_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkshopVideo $workshopVideo, EntityManagerInterface $entityManager, WorkshopRepository $workshopRepository, $workshop_slug): Response
    {
        $workshop = $workshopRepository->findOneBy(['slug' => $workshop_slug]);
        $form = $this->createForm(WorkshopVideoType::class, $workshopVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workshop_edit', ['slug' => $workshop->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/video/edit.html.twig', [
            'workshop_video' => $workshopVideo,
            'form' => $form,
            'workshop' => $workshop
        ]);
    }

    #[Route('/{slug}', name: 'workshop_video_delete', methods: ['POST'])]
    public function delete(Request $request, WorkshopVideo $workshopVideo, EntityManagerInterface $entityManager, $workshop_slug): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshopVideo->getSlug(), $request->request->get('_token'))) {
            $entityManager->remove($workshopVideo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workshop_edit', ['slug' => $workshop_slug], Response::HTTP_SEE_OTHER);
    }
}
