<?php

namespace App\Controller\Admin;

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/customer')]
class CustomerController extends AbstractController
{
    #[Route('/', name: 'admin_customer_index')]
    public function index(CustomerRepository $customerRepository): Response
    {
        return $this->render('admin/customer/index.html.twig', [
            'customers' => $customerRepository->findAll(),
            'active_menu' => 'customers'
        ]);
    }
}
