<?php

namespace App\Controller\Admin;

use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/paiements')]
class ApiPaymentController extends AbstractController
{
    #[Route('/', name: 'admin_api_payments_index')]
    public function index(PaymentRepository $paymentRepository): Response
    {
        return $this->render('admin/api_payment/index.html.twig', [
            'payments' => $paymentRepository->findAll(),
            'active_menu' => 'payments'
        ]);
    }

}
