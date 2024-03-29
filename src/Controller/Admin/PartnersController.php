<?php

namespace App\Controller\Admin;

use App\Entity\Partners;
use App\Form\PartnersType;
use App\Repository\PartnersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/partenaires')]
class PartnersController extends AbstractController
{
    #[Route('/', name: 'partners_index', methods: ['GET'])]
    public function index(PartnersRepository $partnersRepository): Response
    {
        return $this->render('admin/partners/index.html.twig', [
            'partners' => $partnersRepository->findAll(),
            'active_menu' => 'partners'
        ]);
    }

    #[Route('/new', name: 'partners_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $partner = new Partners();
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/partners/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
            'active_menu' => 'partners'
        ]);
    }

    #[Route('/{id}/edit', name: 'partners_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Partners $partner): Response
    {
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
            'active_menu' => 'partners'
        ]);
    }

    #[Route('/{id}', name: 'partners_delete', methods: ['POST'])]
    public function delete(Request $request, Partners $partner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partners_index', [], Response::HTTP_SEE_OTHER);
    }
}
