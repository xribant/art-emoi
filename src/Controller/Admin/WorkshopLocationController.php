<?php

namespace App\Controller\Admin;

use App\Entity\WorkshopLocation;
use App\Form\WorkshopLocationType;
use App\Repository\WorkshopLocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/workshop/location')]
class WorkshopLocationController extends AbstractController
{
    #[Route('/', name: 'workshop_location_index', methods: ['GET'])]
    public function index(WorkshopLocationRepository $workshopLocationRepository): Response
    {
        return $this->render('admin/workshop_location/index.html.twig', [
            'workshop_locations' => $workshopLocationRepository->findAll(),
            'active_menu' => 'localisation'
        ]);
    }

    #[Route('/new', name: 'workshop_location_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $workshopLocation = new WorkshopLocation();
        $form = $this->createForm(WorkshopLocationType::class, $workshopLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workshopLocation);
            $entityManager->flush();

            return $this->redirectToRoute('workshop_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop_location/new.html.twig', [
            'workshop_location' => $workshopLocation,
            'form' => $form,
            'active_menu' => 'localisation'
        ]);
    }

    #[Route('/{id}/edit', name: 'workshop_location_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkshopLocation $workshopLocation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WorkshopLocationType::class, $workshopLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workshop_location_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop_location/edit.html.twig', [
            'workshop_location' => $workshopLocation,
            'form' => $form,
            'active_menu' => 'localisation'
        ]);
    }

    #[Route('/{id}', name: 'workshop_location_delete', methods: ['POST'])]
    public function delete(Request $request, WorkshopLocation $workshopLocation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshopLocation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($workshopLocation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workshop_location_index', [], Response::HTTP_SEE_OTHER);
    }
}
