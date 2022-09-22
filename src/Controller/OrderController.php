<?php

namespace App\Controller;

use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order')]
    public function index(): Response
    {
       $form = $this->createform(OrderType::class,null,['user' => $this->getUser()
    ]);
    
        return $this->render('order/index.html.twig',[
            'form' =>$form->createView()
        ]);
    }
}
