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
    public function get(){
    $session = $this ->requestStack->getSession();

    return $session->get('cart');

            
    }

    public function remove(){
        $session = $this ->requestStack->getSession();
        return $session->remove('cart');

    }








}


?>