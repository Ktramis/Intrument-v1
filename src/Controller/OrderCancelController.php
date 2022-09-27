<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {

        $this->entityManager = $entityManager;

    }

    #[Route('/order/cancel/{stripeSessionId}', name: 'app_order_cancel')]
    public function index( $stripeSessionId): Response
    {
        $order = $this ->entityManager->getRepository(Order::class)->findOneByStripSessionId($stripeSessionId);

        //si la commande n'existe pas OU que l'utilisateur ne correspond pas à celui actuellement connecté ALORS 
        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('order_cancel/order_cancel.html.twig', [
           //afficher les quelques informations de la commande de l'utilisateur
            'order' => $order
        ]);
    }
}
