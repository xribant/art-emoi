<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\WorkshopRepository;
use App\Service\CartManager;
use Flasher\Toastr\Prime\ToastrFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactFormController extends AbstractController
{
    #[Route('/contact', name: 'contact_form')]
    public function index(Request $request, WorkshopRepository $workshopRepository, ToastrFactory $toastr, MailerInterface $mailer, CartManager $cartManager): Response
    {
        $cart = $cartManager->getCart();

        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from($contact->getEmail())
                ->to(new Address('info@art-emoi.be'))
                ->subject($contact->getSubject())
                ->htmlTemplate('mails/contact_form.html.twig')
                ->context([
                    'contact' => $contact
                ])
            ;

            $mailer->send($email);

            $toastr
                ->success('<strong>Message reçu! <br>Nous y répondrons dans les meilleurs délais.</strong>')
                ->timeOut(5000)
                ->progressBar()
                ->closeButton()
                ->positionClass('toast-top-left')
                ->flash()
            ;

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'contact',
            'workshops' => $workshopRepository->findAll(),
            'cart' => $cart
        ]);
    }
}
