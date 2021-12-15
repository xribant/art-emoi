<?php

namespace App\Controller;

use App\Entity\WorkshopInfos;
use App\Form\WorkshopInfosType;
use App\Repository\WorkshopInfosRepository;
use App\Repository\WorkshopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/workshop/{workshop_id}/infos')]
class WorkshopInfosController extends AbstractController
{
    #[Route('/new', name: 'workshop_infos_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, WorkshopRepository $workshopRepository, $workshop_id): Response
    {
        $workshop = $workshopRepository->findOneBy(['id' => $workshop_id]);
        $workshopInfo = new WorkshopInfos();
        $form = $this->createForm(WorkshopInfosType::class, $workshopInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $workshopInfo->setWorkshop($workshop);
            $entityManager->persist($workshopInfo);
            $entityManager->flush();

            return $this->redirectToRoute('workshop_edit', ['id' => $workshop->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/infos/new.html.twig', [
            'workshop_info' => $workshopInfo,
            'form' => $form,
            'workshop' => $workshop
        ]);
    }

    #[Route('/{id}/edit', name: 'workshop_infos_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkshopInfos $workshopInfo, EntityManagerInterface $entityManager, WorkshopRepository $workshopRepository, $workshop_id): Response
    {
        $workshop = $workshopRepository->findOneBy(['id' => $workshop_id]);
        $form = $this->createForm(WorkshopInfosType::class, $workshopInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workshop_edit', ['id' => $workshop->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/workshop/infos/edit.html.twig', [
            'workshop_info' => $workshopInfo,
            'form' => $form,
            'workshop' => $workshop
        ]);
    }

    #[Route('/{id}', name: 'workshop_infos_delete', methods: ['POST'])]
    public function delete(Request $request, WorkshopInfos $workshopInfo, EntityManagerInterface $entityManager, $workshop_id): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshopInfo->getId(), $request->request->get('_token'))) {
            $entityManager->remove($workshopInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workshop_edit', ['id' => $workshop_id], Response::HTTP_SEE_OTHER);
    }
}
