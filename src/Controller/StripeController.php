<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Produit;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Migrations\Configuration\Migration\Exception\JsonNotValid;

class StripeController extends AbstractController
{
    #[Route('/order/create-session/{reference}', name: 'stripe-create')]
    public function index(Cart $cart,EntityManagerInterface $entityManager,$reference): Response
    {
        // ******************************************stripe***********************************************//
        // faire attention a la cle api car si on possede la clé api d'un autre person les paimmen vont passe sur sont compte
        Stripe::setApiKey('sk_test_51LmG10EF5BWtHw7oqGFV5kMA2RJKE4F31vKxIQ9Xj1ftK6Ymx39QA3alQP3Kgt5XFbQjNsLBrzIqG9ludNJRwnhS00xzu32aG0');
             // l'uttilisation :: montre que il sagie une methode statique 

        $YOUR_DOMAIN ='http://127.0.0.1:8000/';

        // Creation d'un tableau vide dans la varable 
        $produit_for_stripe=[];

        $order =$entityManager->getRepository(Order::class)->findOneByReference($reference);

       foreach ($order->getOrderDetails()->getValues() as $produit) {
        $produit_object =$entityManager->getRepository(Produit::class)->findOneByName($produit->getProduct());
        //produit
        $produit_for_stripe[] = [
            'price_data'=> [
                'currency' => 'eur',
                'unit_amount'=>$produit->getPrice(),
                'product_data'=>[
                    'name'=>$produit->getProduct(),
                    'image'=>[],
                ],
            ],
            'quantity' =>$produit->getQuantity(),


        ];


       }
        $produit_for_stripe[]=[
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice(),
                'product_data'=>[
                    'name'=>$order->getCarrierName(),
                    'image'=>[],
                ],
            ],
            'quantity'=> 1,
        ];

            $chekout_session= Session::create([
                  // donne automatiquement l'email de luttilisateur connecter
                  'customer_email' => $this->getUser()->getEmail(),
                  'payment_method_types' => ['card'],
                  'line_items' => [
                    $produit_for_stripe,
                  ],
                  'mode'=>'payment',
                  'success_url'=>$YOUR_DOMAIN.'/success.html',
                  'cancel_url'=>$YOUR_DOMAIN.'/cancel.html', 
                ]);


        return $this->redirect($chekout_session->url);
    }
}
