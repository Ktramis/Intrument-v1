<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RepositoryController extends AbstractController

{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)//inportation de depandance
    {
        $this ->entityManager = $entityManager;
    }
    
    #[Route('/connextion', name: 'app_repository')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        //creaton de nouvelle uttilisateur $user
        $user = new User;

        //creation du formulaire $form
        $form= $this-> createForm(RegisterType::class,$user);

        $form->handleRequest($request);
        //si le formulaire est envoyer et est valide
        if ($form->isSubmitted()&& $form ->isValid()){

            $user=$form->getData();

            $password = $passwordHasher -> hashPassword($user,$user->getPassword());

            $user->setPassword($password);

            //FIGE LA DATA POUR L'ENREGISTREMENT
            $this ->entityManager->persist($user);

            //execute
            $this ->entityManager->flush();
        }

        return $this->render('repository/index.html.twig',[
            'form'=>$form-> createView()
        ]);
        // on met la variable $form dans la cle form
    }
}

