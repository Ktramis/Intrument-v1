<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }



    #[Route('/account/address', name: 'address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/account/address-add', name: 'address-add')]
    public function add(Request $request,Cart $cart): Response
    {
        $address = new Address ;   

        $form = $this->createForm(AddressType::class,$address);
        $form->handleRequest($request);
        
     
        if ($form->isSubmitted()&& $form ->isValid()){

            $address->setUser($this->getUser());


           

            

            //FIGE LA DATA POUR L'ENREGISTREMENT
            $this ->entityManager->persist($address);

            //execute
            $this ->entityManager->flush();

            // $notification="Votre compte a ete enregistre vous pouver desormet vous connecter";
            if ($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('app_account_address');
            }


            return $this->redirectToRoute('address');
            
        }

        return $this->render('account/address_add.html.twig',[
            'form' => $form->createView()
            
        ]);
       
    }

    #[Route('/account/remove-address/{id}', name: 'address-remove')]
    public function remove(Request $request,$id): Response
    {
         // je recupere l'adresse dans la basse de donne grace a entity manager
        // et c'est grace a doctrine que je peut requper l'adreese en ciblent id
        $address = $this->entityManager->getRepository(Address::class)->findOneById($id);

        //si il y a une addresse et que luttilisateur repertotier a l'addresse correspont a luttilisateur actuel Alors
       if (!$address || $address->getUser()== $this->getUser()){
        //On  supprime l'addresse dans la basse de donne 
        $this->entityManager->remove($address);
        // execute 
        $this->entityManager->flush();

       }

        return $this->redirectToRoute('address');
    }

    #[Route('/account/address-edit/{id}', name: 'address-eddit')]
    public function eddit(Request $request,$id): Response
    {
        // on cible l'addresse deja exitant au lieu de crée un nouveau
        $address =$this->entityManager->getRepository(Address::class)->findOneById($id);
        
        // si l'addresse cible n'a pas le meme uttilisateur que l'uttilisatuer actuel redirriger ver la page de gestion  addresse
        if (!$address || $address->getUser() != $this ->getUser()){
            return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class,$address);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $address->setUser($this->getUser());

            //FIGE LA DATA POUR L'ENREGISTREMENT
            $this ->entityManager->persist($address);

            //execute
            $this ->entityManager->flush();

            // $notification="Votre compte a ete enregistre vous pouver desormet vous connecter";

           
            return $this->redirectToRoute('address');
            
        }

        



        return $this->render('account/address_add.html.twig',[
            'form' => $form->createView()
            
        ]);
    }

}
?>