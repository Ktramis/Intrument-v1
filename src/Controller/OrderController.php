<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Produit;
use App\Form\OrderType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }







    #[Route('/order', name: 'app_order')]
    public function index(Cart $cart,): Response
    {
         // Si l'utilisateur n'a pas d'adresses ALORS
         if (!$this->getUser()->getAddresses()->getValues()) {
            // On le redirige vers la page d'ajout d'adresse
            return $this->redirectToRoute('account_address_add');
        }
       $form = $this->createform(OrderType::class,null,[
        'user' => $this->getUser()
        ]);
        
    
        return $this->render('order/index.html.twig',[
            'form' =>$form->createView(),
            'cart'=>$cart->getFull(),
        ]);
    }

    #[Route('/order/summary', name: 'summary',methods:('POST'))]
    
    public function add(Cart $cart,Request $request)
    {
        $form = $this->createform(OrderType::class,null,[
            'user' => $this->getUser()
            ]);

        //ecoute la requete 
        $form->handleRequest($request);
        
        //si le formulaire et envoyer et est valider
        if ($form->isSubmitted() && $form->isValid()) { 
            //on enregistre la date et l'heure dans un nouvel object
            $date= new DateTime();
            // on accede a carriere
            // dans la varible carrire , dans le formulaire optient carrires et recupere ses donne
            $carrier =$form->get('Carrier')->getData();
            // dans la varriable deliverie,dans la formulaire optient addresse et recuper ses donne
            $deliverie =$form->get('addresses')->getData();
           
            // dd($deliverie);

            //vue que on ne veur pas tout les information de deliverie on vas crée une nouvel varriable et on va stoquer se que l'on a bessoin d'afficher et de garder en donné

            $deliverie_content = $deliverie->getFirstname().' '.$deliverie->getLastname();
            $deliverie_content .= '<br>'.$deliverie->getPhone();
            // le .= est comme un += c'est a dire au lieu d'acctualiser on ajoute se qui se trouve deja dans la variable a se qui y a derrire le = ici c'a reste juste une grande concatenation

            // si il y a une companie enregistre 
            if($deliverie->getCompany()){
                $deliverie_content .= '<br> '.$deliverie->getCompany();
            }
            $deliverie_content .= '<br> '.$deliverie->getCountry();
            $deliverie_content .= ' '.$deliverie->getCity();
            $deliverie_content .= ' '.$deliverie->getpostal();
            $deliverie_content .= '<br> '.$deliverie->getaddress();


            //enregistre ma commande (order tout ce qui tout au lieu de livraison le chauffeur le prix totale)


            




            //nouvelle object
            $order= new Order;
           // on definit m'uttilisateur d'order comme etant l'uttilisateur de la session actuel
            $order->setUser($this->getUser());
            //on lu donne la l'object date crée l'ors de la validation 
            $order->setCreatedAt($date);
            // on vas cherche le CarrireName (nom du chauffeur) d'order dans le name (nom) de la varible carrier
            // on deffinit carrirername comme etant le name dans la varable carriere
            $order->setCarrierName($carrier->getName());
             // on vas cherche le Carrireprice(pris du chauffeur) d'order dans le price(pris) de la varible carrier
            //  on deffinit carrirer price d'order comme etant le price dans la variable carrier
            $order->setCarrierPrice($carrier->getPrice());

            // on donne au Deliverie d'order toute la variable $deliverie_content
            // on definit le deliverie comme etant l'integralite de la variable deliverie_content
            $order->setDeliverie($deliverie_content);
            //le ispaid est un booleen on le deffinit de bass a 0
            $order->setIsPaid(0);
        
            // on vas mantenent fichier la data(essensiel de le faire maintenemt vue que on a bessois des donné d'order pour order dettail)
            $this->entityManager->persist($order);

            




            //enregistre mes produit(order detaills tout ce qui est la quantiter des produit, le nombre de produit diffenret et le prix de chaqu'un )

            //orderdetaill a besoin de tout les produit donc on vais faire un foreach et un $cart getFull pour recupere tout les prduit du panier

            // pour chaque produit dans le panier faire une interation et faire une nouvelle entre dans order dettail
            foreach($cart->getFull()as $produit){
                //nouvelle object    
                $orderdetails = new OrderDetails;
                // on reaffirme la relation entre les deux entité
                $orderdetails->setMyOrder($order);

                // on va chercher le product dans la variable produit dans le  nom dans la clé produit
                $orderdetails->setProduct($produit['produit']->getName());
                // on vas chercher la quantite de orderdetails dans la variable produit  et dans la clé quantiter
                $orderdetails->setQuantity($produit['quantity']);

                $orderdetails->setPrice($produit['produit']->getPrice());

                $orderdetails->setTotal($produit['produit']->getPrice() * $produit['quantity'] );

                //on fige les donné de orderDetails
                $this->entityManager->persist($orderdetails);

                

            }
            // on enregitre les donné dans la basse de donne
            // $this->entityManager->flush();

            return $this->render('order/add.html.twig',[
                'cart'=>$cart->getFull(),
                'deliverie'=>$deliverie_content ,
                'carrier'=>$carrier,

            ]);
        }
    }
}
