<?php

namespace App\Controller;

use App\Entity\Event;
use App\Service\CartManager;
use Flasher\Toastr\Prime\ToastrFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/panier')]
class CartController extends AbstractController
{
    
    #[Route('/', name: 'app_cart')]
    public function index(CartManager $cartManager): Response
    {
        $cart = $cartManager->getCart();

        return $this->render('cart/index.html.twig', [
            'current_menu' => 'cart',
            'cart' => $cart
        ]);

    }

    #[Route('/ajouter/{uid}', name: 'app_cart_add')]
    public function add(SessionInterface $session, Event $event, ToastrFactory $toastr): Response
    {
        $cart = $session->get('panier', []);
        $uid = $event->getUid();

        if(!empty($cart)){
            // $cart[$uid]++;
            $toastr
                ->warning('Vous avez déjà une formation dans votre panier d\'achat. Veuillez supprimer celle-ci si vous désirez en sélectionner une autre.')
                ->timeOut(15000)
                ->progressBar()
                ->closeButton()
                ->positionClass('toast-top-center')
                ->flash()
            ;

            return $this->redirectToRoute('app_cart');

        }else{
            $cart[$uid] = 1;
        }

        $session->set("panier", $cart);

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/supprimer/{uid}', name: 'app_cart_remove')]
    public function remove(SessionInterface $session, Event $event): Response
    {
        $cart = $session->get('panier', []);
        $uid = $event->getUid();

        if(!empty($cart[$uid])){
            if($cart[$uid] > 1){
                $cart[$uid]--;
            } else {
                unset($cart[$uid]);
            }
        }

        $session->set("panier", $cart);

        return $this->redirectToRoute('app_cart');
    }
}
