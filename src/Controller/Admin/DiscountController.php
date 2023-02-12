<?php

namespace App\Controller\Admin;

use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\DiscountRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/discount')]
class DiscountController extends AbstractController
{
    #[Route('/', name: 'app_discount_index', methods: ['GET'])]
    public function index(DiscountRepository $discountRepository): Response
    {
        return $this->render('admin/discount/index.html.twig', [
            'discounts' => $discountRepository->findAll(),
            'active_menu' => 'promos'
        ]);
    }

    #[Route('/new', name: 'app_discount_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DiscountRepository $discountRepository): Response
    {
        $discount = new Discount();
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discount->setCode(strtoupper($discount->getCode()));
            $discountRepository->add($discount);
            return $this->redirectToRoute('app_discount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/discount/new.html.twig', [
            'discount' => $discount,
            'form' => $form,
            'active_menu' => 'promos'
        ]);
    }

    #[Route('/{uid}/edit', name: 'app_discount_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Discount $discount, DiscountRepository $discountRepository): Response
    {
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $discountRepository->add($discount);
            return $this->redirectToRoute('app_discount_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/discount/edit.html.twig', [
            'discount' => $discount,
            'form' => $form,
            'active_menu' => 'promos'
        ]);
    }

    #[Route('/{uid}', name: 'app_discount_delete', methods: ['POST'])]
    public function delete(Request $request, Discount $discount, DiscountRepository $discountRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discount->getUid(), $request->request->get('_token'))) {
            $discountRepository->remove($discount);
        }

        return $this->redirectToRoute('app_discount_index', [], Response::HTTP_SEE_OTHER);
    }
}
