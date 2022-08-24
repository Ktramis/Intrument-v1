<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('lastname',TextType::class,[
            'label'=>'Entre votre nom'
        ])

        ->add('firstname',TextType::class,[
            'label'=>'Entre votre prenom'
        ])
    
        ->add('email',EmailType::class,[
            'label'=>'Tape votre adresse email'
        ])
        
        ->add('password',PasswordType::class,[
            'label'=>'Entre votre mot de passe'
        ])
        
        ->add('submit',SubmitType::class,[
            'label'=>"s'inscrire"
        ])
        
         ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
