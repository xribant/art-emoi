<?php

namespace App\Controller;

use App\Repository\EventRepository;
use App\Repository\OrderRepository;
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
        $orderRef = strtoupper(uniqid());

        Stripe::setApiKey($stripeSK);

        $event = $cart['dataCart'][0]['event'];

        $session = Session::create([
            'payment_method_types' => ['card','bancontact', 'sepa_debit'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'EUR',
                'product_data' => [
                  'name' => $event->getProduct()->getTitle(),
                ],
                'unit_amount' => $cart['total'] * 100,
              ],
              'quantity' => $cart['dataCart'][0]['quantity'],
              'dynamic_tax_rates' => [
                'txr_1Md8xyIcnOmfzboloeZ26uT9',
                'txr_1Md8xWIcnOmfzbolqLgk8Ept'
              ],
            ]],
            'expand' => ['total_details'],
            'mode' => 'payment',
            'billing_address_collection' => 'required',
            'phone_number_collection' => [
              'enabled' => true
            ],
            'tax_id_collection' => [
              'enabled' => true,
            ],
            'metadata' => [
              'event_id' => $event->getId(),
              'order_ref' =>  $orderRef
            ],
            'success_url' => $this->generateUrl('success_url', ['orderRef' => $orderRef], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('cancel_url', [], UrlGeneratorInterface::ABSOLUTE_URL),
            ]);

          return $this->redirect($session->url, 303);
    }

    #[Route('/payment-success/{orderRef}', name: 'success_url')]
    public function success(CartManager $cartManager, OrderRepository $orderRepository, $orderRef): Response
    {
        $cartManager->emptyCart();
        $order = $orderRepository->findOneBy(['uid' => $orderRef]);
        
        return $this->render('payment/success.html.twig', [
            'current_menu' => "",
            'order' => $order
        ]);
    }

    #[Route('/payment-cancel', name: 'cancel_url')]
    public function cancel(): Response
    {
        return $this->render('payment/cancel.html.twig', ['current_menu' => '']);
    }
}
