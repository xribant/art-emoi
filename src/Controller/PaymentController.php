<?php

namespace App\Controller;

use App\Service\CartManager;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{
    #[Route('/checkout', name: 'app_checkout')]
    public function checkout($stripeSK, CartManager $cartManager): Response
    {
       
        $cart = $cartManager->getCart();

        Stripe::setApiKey($stripeSK);

        $session = Session::create([
            'payment_method_types' => ['card','bancontact', 'sepa_debit'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'EUR',
                'product_data' => [
                  'name' => 'Formation au Carnet de deuil',
                ],
                'unit_amount' => $cart['total'] * 100,
              ],
              'quantity' => $cart['dataCart'][0]['quantity'],
            ]],
            'mode' => 'payment',
            'billing_address_collection' => 'required',
            'phone_number_collection' => [
              'enabled' => true
            ],
            'metadata' => [
              'event_id' => $cart['dataCart'][0]['event']->getId()
            ],
            'success_url' => $this->generateUrl('success_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

          return $this->redirect($session->url, 303);
    }

    #[Route('/payment-success', name: 'success_url')]
    public function success(): Response
    {
        return $this->render('payment/success.html.twig', [
            'current_menu' => ""
        ]);
    }

    #[Route('/payment-cancel', name: 'cancel_url')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig');
    }
}
