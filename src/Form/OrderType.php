<?php

namespace App\Form;

use App\Entity\Address;
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
                'label'=>false,
                // obligatoire
                'required'=>true,
                'class'=>Address::class,
                // il faut aller chercher les choi sdans les addresse de l'uttiliseur
                'choices'=>$user->getAddresses(),
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
