<?php

namespace App\Controller;

use App\Entity\EventRegistration;
use App\Form\FrontRegistrationType;
use App\Repository\EventRepository;
use App\Repository\WorkshopRepository;
use Flasher\Toastr\Prime\ToastrFactory;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class FrontRegistrationController extends AbstractController
{
    #[Route('/inscription/{event_uid}', name: 'front_registration')]
    public function index(Request $request, WorkshopRepository $workshopRepository, MailerInterface $mailer, ToastrFactory $toastr, EventRepository $eventRepository, $event_uid): Response
    {
        $event = $eventRepository->findOneBy(['uid' => $event_uid]);

        $eventRegistration = new EventRegistration();

        $form = $this->createForm(FrontRegistrationType::class, $eventRegistration);
        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()) {

            $eventRegistration->setEvent($event);

            $email = (new TemplatedEmail())
                ->from('admin@art-emoi.be')
                ->to(new Address($eventRegistration->getEmail()))
                // ->cc('admin@art-emoi.be')
                ->subject('Art-Emoi : Demande d\'inscription')
                ->htmlTemplate('mails/registration_confirmation.html.twig')
                ->context([
                    'registration' => $eventRegistration,
                ])
            ;

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $toastr
                    ->warning('Inscription invalide. L\'adresse e-mail introduite à l\'inscription n\'existe pas !!!')
                    ->timeOut(10000)
                    ->progressBar()
                    ->closeButton()
                    ->positionClass('toast-top-left')
                    ->flash()
                ;

                return $this->redirectToRoute('home');
            }

            $entityManager = $this->getDoctrine()->getManager();
            $eventRegistration->setStatus('new');
            $eventRegistration->setArchived(false);
            $eventRegistration->setUid(uniqid("",false).bin2hex(random_bytes(20)));
            $entityManager->persist($eventRegistration);
            $entityManager->flush();

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
            'event' => $event
        ]);
    }
}
