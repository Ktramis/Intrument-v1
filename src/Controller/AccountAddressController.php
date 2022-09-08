<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    // private $entityManager;

    // public function __construct(EntityManagerInterface $entityManager)
    // {
    //     $this->entityManager=$entityManager;
    // }



    #[Route('/account/address', name: 'address')]
    public function index(): Response
    {
        return $this->render('account/address.html.twig');
    }

    #[Route('/account/address-add', name: 'address-add')]
    public function add(): Response
    {
        $address = new Address ;   

        $form = $this->createForm(AddressType::class,$address);

        return $this->render('account/address_add.html.twig',[
            'form' => $form->createView(),
        ]);
    }
}
?>