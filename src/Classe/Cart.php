<?php
namespace App\Classe;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart{
    // RequestStack permet d'acceder a une requette en cours d'uttilisation

    private $requestStack;
    private $entityManager;
    
    
    public function __construct(RequestStack $requestStack,EntityManagerInterface $entityManager)
    {
        $this->requestStack = $requestStack;
        $this->entityManager=$entityManager;
    }

    //ajouter au panier
    public function add($id){

        //avec la variable id en parametre  
        //lancer la sesion 
        $session = $this ->requestStack->getSession();




         //on recupere les informaion du panier d a l'aide de la session 
         $cart =$session->get('cart',[]);
    
         //Si dans le panier il y a deha un produit insere
         if (!empty($cart[$id])){
            //on incremente de 1
            $cart[$id]++;
         }else{
            //Sino allors est egal a 1
            $cart[$id]=1;
         }
         //on stoque les information du panier dans la session (cart)
         $session->set('cart',$cart);


        
    }

      //suprimer une qunatitier d'un produit
      public function sub($id){

        //avec la variable id en parametre  
        //lancer la sesion 
        $session = $this ->requestStack->getSession();




         //on recupere les informaion du panier d a l'aide de la session 
         $cart =$session->get('cart',[]);
    
         //Si la nombre de fois ou l'id a ete appele est superieur a 1
         if (($cart[$id])> 1){
            //on decremente  de 1
            $cart[$id]--;
         }else{
           //alors on suprime  du panier
             unset( $cart[$id]);
         }
         //on stoque les information du panier dans la session (cart)
         $session->set('cart',$cart);


        
    }



    public function get(){
    $session = $this ->requestStack->getSession();

    return $session->get('cart');

            
    }
    //suprimer le produit
    public function delete($id){
        $session = $this ->requestStack->getSession();
         //on recupere les informaion du panier d a l'aide de la session 
         $cart =$session->get('cart',[]);
        
         //on supprime l'element 
         unset($cart[$id]);

         //on stoque les information du panier dans la session (cart)(ou dans cette situation on actualise)
         return $session->set('cart',$cart);

    }

    public function remove(){
        $session = $this ->requestStack->getSession();
        return $session->remove('cart');

    }


    public function getFull(){
        $cartComplete = [];

        if($this->get()) {
          foreach ($this->get() as $id => $quantity) {
            // Je récupère l'ID du produit en base de données
            $produit_object = $this->entityManager->getRepository(Produit::class)->findOneById($id);

            // SI le produit n'existe pas
            if (!$produit_object) {
              // On le supprime du panier
              $this->delete($id);
              continue;//conituet  est comme le break on sort de la boucle 
            }

            $cartComplete[] = [
              'produit' => $produit_object,
              'quantity' => $quantity
            ];
          } 
        }

        return $cartComplete;

    }





}


?>