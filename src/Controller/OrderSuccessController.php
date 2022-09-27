<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;

    }

    #[Route('/order/success/{stripSessionId}', name: 'app_order_success')]
    public function index(Cart $cart, $stripSessionId): Response
    {
        $order = $this ->entityManager->getRepository(Order::class)->findOneByStripSessionId($stripSessionId);

        //si la commande n'existe pas OU que l'utilisateur ne correspond pas à celui actuellement connecté ALORS 
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }


          //si la commande est en statu NON PAYé 
        if (!$order->isIsPaid()){ 

            //vider la session "cart"
            $cart->remove();

            //modifier le statu isPaid de notre commande en mettant 1
            $order -> setIsPaid(1);

            //éxecute
            $this->entityManager->flush();
            
            //envoyer un email automatique lors de la finalisation de la commande pour dire que c'est validé 
            // $mail = new Mail();

            // contenu du message
            // $content = "Bonjour " . $order->getUser()->getFirstName()."," . "</br> Merci pour votre commande.";

            // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande sur DronaMada est bien validée', $content);

        }

        return $this->render('order_success/order_success.html.twig', [
           //afficher les quelques informations de la commande de l'utilisateur
            'order' => $order
        ]);
    }
}