<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Produit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }




    //rout du panier 
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        
        $cartComplet = [];

        foreach ($cart->get() as $id => $quantity ){
            $cartComplet[] = [
                'produit' =>$this->entityManager->getRepository(Produit::class)->findOneById($id),
                'quantity' =>$quantity
            ];

        }


        // dd($cart->get());//on verifi le fonctionement 
        return $this->render('cart/index.html.twig',[
            'cart'=>$cartComplet
        ]);
    }

    //lors d'un ajout de produit rout ver le panier avec le fonction add
    #[Route('/cart/add/{id}', name: 'add-to-cart')]
    public function add(Cart $cart,$id): Response
    {
        //enreigiste l'id du produit qui a ete clicker et enregitre le nombre de fois ( Donc la fonction add)
        // cest pour cela que la variable id est en Parametre de cete fonction 
        $cart->add($id);
          //redirige ver le panier (ou on affichera le donne enrgistre )
        return $this->redirectToRoute('app_cart');
      
    }
      //supretion de une unite de porduit
      #[Route('/cart/sub/{id}', name: 'sub-to-cart')]
      public function sub(Cart $cart,$id): Response
      {
           
          $cart->sub($id);

            //redirige ver le panier (ou on affichera le donne enrgistre )
          return $this->redirectToRoute('app_cart');
        
      }

      //effacer un produit
      #[Route('/cart/delete/{id}', name: 'delete-to-cart')]
      public function delete(Cart $cart,$id): Response
      {
         $cart->delete($id);

        return $this->redirectToRoute('app_cart');
      }



    // effacer tout le panier
    #[Route('/cart/remove', name: 'app-to-remove')]
    public function remove(Cart $cart): Response
    {
       $cart->remove();
      return $this->redirectToRoute('app_produit');
    }


}
