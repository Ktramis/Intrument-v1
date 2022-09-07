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
        //ici on a suprimer le foreach et la varible cartController pour deux reasion qui sont lier l'une a lautre ,premierment sans ce cahgement si quelqun aurai voulue aller sur son panier alors que le panier est vide c'ella aurai donne une erreur 404  ce qui ammemene a la deuxieme raison c'est un faille de securite au niveau des produit don affint de pouvoir arrenger cela on a crée un fonction getFull dans cart.php  

        // dd($cart->get());//on verifi le fonctionement 
        return $this->render('cart/index.html.twig',[
            'cart'=>$cart->getFull()
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
