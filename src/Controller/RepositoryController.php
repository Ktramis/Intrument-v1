<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepositoryController extends AbstractController
{
    #[Route('/connextion', name: 'app_repository')]
    public function index(): Response
    {
        //creaton de nouvelle uttilisateur $user
        $user = new User;

        //creation du formulaire $form
        $form= $this-> createForm(RegisterType::class,$user);

        return $this->render('repository/index.html.twig',[
            'form'=>$form-> createView()
        ]);
        // on met la variable $form dans la cle form
    }
}

