<?php

namespace App\Controller;

use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AccessCodeType;
use Symfony\Component\HttpFoundation\RequestStack;

class FrontTrainingController extends AbstractController
{

    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/formations', name: 'app_front_training')]
    public function index(WorkshopRepository $workshopRepository, Request $request): Response
    {
        $code = [];

        $form = $this->createForm(AccessCodeType::class, $code);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            
            $hashedCode = base64_encode(strtoupper($form->getData()['key'])); 

            $session = $this->requestStack->getSession();
            $session->set('activation_code', $hashedCode);

            dump($session);
        }

        return $this->render('front_training/index.html.twig', [
            'current_menu' => 'training',
            'form' => $form->createView(),
            'workshops' => $workshopRepository->findAll()
        ]);
    }
}
