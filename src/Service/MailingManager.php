<?php

namespace App\Service;

use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class MailingManager {

    private $params;
    private $mailer;

    public function __construct(MailerInterface $mailer, ContainerBagInterface $params){
        $this->mailer = $mailer;
        $this->params = $params;
    }

    public function sendInvoice($customer, $invoice, $order)
    {
        $email = (new TemplatedEmail())
            ->from('admin@art-emoi.be')
            ->to(new Address($customer->getEmail()))
            ->subject('Art-Emoi : Facture n° '.$invoice->getId())
            ->htmlTemplate('mails/invoice_confirmation.html.twig')
            ->attachFromPath($this->params->get('kernel.project_dir') . '/public/media/cache/invoices/'.$invoice->getFileName(), $invoice->getFileName(), 'application/pdf')
            ->context([
                'order' => $order,
                'invoice' => $invoice
            ])
        ;

        $this->mailer->send($email);
        
    }

    public function sendOrderConfirmation($customer, $order){
        $email = (new TemplatedEmail())
            ->from('admin@art-emoi.be')
            ->to(new Address($customer->getEmail()))
            ->subject('Art-Emoi : Confirmation de commande n° '.$order->getUid())
            ->htmlTemplate('mails/order_confirmation.html.twig')
            ->context([
                'order' => $order,
            ])
        ;

        $this->mailer->send($email);
    }

    public function sendOrderCancelation($customer, $order){
        $email = (new TemplatedEmail())
            ->from('admin@art-emoi.be')
            ->to(new Address($customer->getEmail()))
            ->subject('Art-Emoi : Commande annulée')
            ->htmlTemplate('mails/order_cancelation.html.twig')
            ->context([
                'order' => $order,
            ])
        ;

        $this->mailer->send($email);
    }
}