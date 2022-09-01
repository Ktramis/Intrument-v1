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


/////////////////////////////////////////page pour un produit/////////////////////////////////////////////

    #[Route('/produit/{slug}',name:'produit')]
    public function show($slug): Response
    {

        $produit=$this->entityManager->getRepository(Produit::class)->findOneBySlug($slug);
        // on recherche un produit dans la basse de donne corespondant a son slug
            //findOneBySlug -> trouve appartitre de slug

        if(!$produit){
            return $this->redirectToRoute('app_produit');
            // si la il ne trouve pas la varible du produit  redirige ver la page general des produits
        }

        return $this->render('produit/show.html.twig',[
        'produit'=>$produit
    ]);
    }










}
