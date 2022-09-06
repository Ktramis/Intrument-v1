<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Produit;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        //recuperation des donné relative a mon entite produit A l'aide de doctrine dans  mon repository(ProductRepository)
       

        $search = new Search;

        $form = $this->createForm(SearchType::class, $search);

        //echoute la requette 
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
              // $search = $form->getData(); on a pas besoin d'ecrire cette ligne car l'obecjt est deja dans la requette
            
            $produit =$this->entityManager->getRepository(Produit::class)->findWithSearch($search);
        }else{
            $produit =$this->entityManager->getRepository(Produit::class)->findAll();
        }

       
        return $this->render('produit/index.html.twig',[
            "produits"=>$produit,
            'form'=>$form->createView()
        ]);
    }


/////////////////////////////////////////page pour un produit/////////////////////////////////////////////


    //pour que l'argument slug soit bien pris en compt par la fonction on met dans la root /{slug}
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
