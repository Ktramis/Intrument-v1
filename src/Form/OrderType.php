<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // permet a l'uttilisater de de choisire que ces adresse a lui
        $user = $options['user'];
        $builder
            ->add('addresses',EntityType::class,[
                'label'=>'Choissiser votre Addresse de livraison',
                // obligatoire
                'required'=>true,
                // on deffinit la classz
                'class'=>Address::class,
                // il faut aller chercher les choi sdans les addresse de l'uttiliseur
                'choices'=>$user->getAddresses(),
                //on ne peut pas en choissire plussieur
                'multiple'=>false,

                'expanded'=>true
            ])
            ->add('Carrier',EntityType::class,[
                'label'=>'Choissiser votre chauffeur',
                // obligatoire
                'required'=>true,
                'class'=>Carrier::class,
               
                //on ne peut pas en choissire plussieur
                'multiple'=>false,

                'expanded'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user'=>array()
        ]);
    }
}
