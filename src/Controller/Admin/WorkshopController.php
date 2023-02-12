<?php

namespace App\Controller\Admin;

use App\Entity\Workshop;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/workshop')]
class WorkshopController extends AbstractController
{
    #[Route('/', name: 'workshop_index', methods: ['GET'])]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('admin/workshop/index.html.twig', [
            'workshops' => $workshopRepository->findAll(),
            'active_menu' => 'workshop'
        ]);
    }

    #[Route('/new', name: 'workshop_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $workshop = new Workshop();
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workshop);
            $entityManager->flush();

            return $this->redirectToRoute('workshop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/new.html.twig', [
            'workshop' => $workshop,
            'form' => $form,
            'active_menu' => 'workshop'
        ]);
    }

    #[Route('/{slug}/edit', name: 'workshop_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Workshop $workshop): Response
    {
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('workshop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/edit.html.twig', [
            'workshop' => $workshop,
            'form' => $form,
            'active_menu' => 'workshop'
        ]);
    }

    #[Route('/{slug}', name: 'workshop_delete', methods: ['POST'])]
    public function delete(Request $request, Workshop $workshop): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshop->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($workshop);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workshop_index', [], Response::HTTP_SEE_OTHER);
    }
}
