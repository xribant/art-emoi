<?php

namespace App\Controller;

use App\Entity\EventLeadContact;
use App\Form\EventLeadContactType;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EventLeadContactController extends AbstractController
{
    #[Route('/tarot-bonne-resolution/telechargement', name: 'event_lead_form')]
    public function index(Request $request, WorkshopRepository $workshopRepository, SessionInterface $session): Response
    {
    

            $contact = new EventLeadContact();
            $form = $this->createForm(EventLeadContactType::class, $contact);
            $form->handleRequest($request);

            if($form->isSubmitted() and $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($contact);
                $entityManager->flush();

                $session->set("contact_lead_id", uniqid());
                
                return $this->redirectToRoute($request->attributes->get('_route'));
            }
    

        return $this->render('event_lead_contact/index.html.twig', [
            'form' => $form->createView(),
            'current_menu' => 'tarot-bonnes-resolutions',
            'workshops' => $workshopRepository->findAll(),
            
        ]);
    }
}
