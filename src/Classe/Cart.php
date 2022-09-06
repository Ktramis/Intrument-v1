<?php
namespace App\Classe;

use App\Entity\Produit;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart{
    // RequestStack permet d'acceder a une requette en cours d'uttilisation

    private $requestStack;
    
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
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

      //ajouter au panier
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








}


?>