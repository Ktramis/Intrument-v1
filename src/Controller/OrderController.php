<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(Cart $cart): Response
    {
         // Si l'utilisateur n'a pas d'adresses ALORS
         if (!$this->getUser()->getAddresses()->getValues()) {
            // On le redirige vers la page d'ajout d'adresse
            return $this->redirectToRoute('account_address_add');
        }
       $form = $this->createform(OrderType::class,null,['user' => $this->getUser()
    ]);
    
        return $this->render('order/index.html.twig',[
            'form' =>$form->createView(),
            'cart'=>$cart->getFull(),
        ]);
    }
}
