<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    public $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager =$entityManager;
    }


    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $produit =$this->entityManager->getRepository(Produit::class)->findAll();


        return $this->render('home/index.html.twig',[
            'produits'=> $produit
        ]);
    }
}
