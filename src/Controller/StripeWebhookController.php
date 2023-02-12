<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Payment;
use App\Repository\CustomerRepository;
use App\Repository\PaymentRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends AbstractController
{
    #[Route('/payment/webhook', name: 'app_stripe_webhook')]
    public function index(Request $request, $stripeSK, CustomerRepository $customerRepository, PaymentRepository $paymentRepository): Response
    {
        Stripe::setApiKey($stripeSK);
        $webhookSecret = "whsec_808c5b2c541b7b724e0b04798a3848de01f313c299521925f1d0eece70176d52";

        $signature = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $body = (string)$request->getContent();
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $body, $signature, $webhookSecret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Si $event->type == 'checkout.session.completed' 

        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $customer = $customerRepository->findOneBy(['email' => $session->customer_details->email]);

                // Check if customer exist in DB, if not new customer is created
                if(!$customer){
                    $customer = new Customer();

                    $customer->setEmail($session->customer_details->email)
                        ->setName($session->customer_details->name)
                        ->setAddress($session->customer_details->address->line1.' '.$session->customer_details->address->line2)
                        ->setCity($session->customer_details->address->city)
                        ->setZipCode($session->customer_details->address->postal_code)
                        ->setCountry($session->customer_details->address->country)
                        ->setPhone($session->customer_details->phone) 
                    ;

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($customer);
                    $entityManager->flush();
                }

                // Create new payment and store in DB
                $newPayment = new Payment();
                $creationDate = new DateTime();
                $newPayment->setCustomer($customer)
                    ->setAmount($session->amount_total)
                    ->setStripeDescription($session->payment_intent)
                    ->setCreationDate($creationDate->setTimestamp($session->created))
                ;

                // If checkout status is paid, status stored as "Payé" otherwise status stored as "Paiement en attente"
                if($session->payment_status == "paid") {
                    $newPayment->setStatus('Payé')
                        ->setClosureDate(new DateTime());
                        // TO DO
                        // Trigger d'une nouvelle inscription dans la DB + Confirmation au client par e-mail
                } else {
                    $newPayment->setStatus('Paiement en attente');
                        // TO DO
                        // Trigger d'une notification au client que le paiment est en attente
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newPayment);
                $entityManager->flush();  
                
                break;
            
            // Si $event->type == 'checkout.session.async_payment_completed' (Paiement diféré)
            case 'checkout.session.async_payment_succeeded':
                $session = $event->data->object;
                
                // Get the payment in DB
                $payment = $paymentRepository->findOneBy(['stripe_description' => $session->payment_intent]);

                // Update status and set closure date
                if($session->payment_status == "paid") {
                    $payment->setStatus('Payé')
                        ->setClosureDate(new DateTime());
                        // TO DO
                        // Trigger d'une nouvelle inscription dans la DB + Confirmation au client par e-mail
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($payment);
                    $entityManager->flush();
                }
            
                break;
          
            case 'checkout.session.async_payment_failed':
                $session = $event->data->object;
                
                // Get the payment in DB
                $payment = $paymentRepository->findOneBy(['stripe_description' => $session->payment_intent]);

                // Update status to "échoué" and set closure date
                
                $payment->setStatus('Echoué')
                    ->setClosureDate(new DateTime());
                    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($payment);
                $entityManager->flush();
            
                // TO DO
                // Trigger d'une notification au client que le paiment a échoué.
            
                break;
        }

        return new Response (Response::HTTP_OK);  
        
    }
}
