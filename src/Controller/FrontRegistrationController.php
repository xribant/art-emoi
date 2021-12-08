<?php

namespace App\Controller;

use App\Entity\EventRegistration;
use App\Form\FrontRegistrationType;
use App\Repository\WorkshopRepository;
use Flasher\Toastr\Prime\ToastrFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class FrontRegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'front_registration')]
    public function index(Request $request, WorkshopRepository $workshopRepository, MailerInterface $mailer, ToastrFactory $toastr): Response
    {
        $eventRegistration = new EventRegistration();
        $form = $this->createForm(FrontRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setStatus('new');
            $entityManager->persist($eventRegistration);
            $entityManager->flush();

            $email = (new TemplatedEmail())
                ->from($eventRegistration->getEmail())
                ->to(new Address('xavier@mywebcreation.be'))
                ->subject('Art-Emoi : confirmation d\'inscription')
                ->htmlTemplate('mails/registration_confirmation.html.twig')
                ->context([
                    'registration' => $eventRegistration
                ])
            ;

            $mailer->send($email);

            $toastr
                ->success('<strong>Inscription enregistrée! <br>Un e-mail de confirmation vous a été envoyé avec les instructions.</strong>')
                ->timeOut(5000)
                ->progressBar()
                ->closeButton()
                ->positionClass('toast-top-left')
                ->flash()
            ;

            return $this->redirectToRoute('home');
        }

        return $this->render('front_registration/index.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'registration',
            'workshops' => $workshopRepository->findAll()
        ]);
    }
}
