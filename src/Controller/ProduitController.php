<?php

namespace App\Controller;


use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this -> entityManager = $entityManager;
    }

    #[Route('/les-produit', name: 'app_produit')]
    public function index(): Response
    {
        $produit =$this->entityManager->getRepository(Produit::class)->findAll();

        return $this->render('produit/index.html.twig',["produits"=>$produit]);
    }
}
