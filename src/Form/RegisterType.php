<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        ->add('lastname',TextType::class,[
            'label'=>'Entre votre nom',
            'attr'=>[
                'placeholder'=>'Merci de metre votre nom'
            ]
        ])

        ->add('firstname',TextType::class,[
            'label'=>'Entre votre prenom',
            'attr'=>[
                'placeholder'=>'Merci de metre votre prenom'
            ]
        ])
    
        ->add('email',EmailType::class,[
            'label'=>'Tape votre adresse email',
            'attr'=>[
                'placeholder'=>'Merci de metre votre email'
            ]
        ])
        
        ->add('password',RepeatedType::class,[
            'type'=>  PasswordType::class,
            'invalid_message' => "le mot des passe n'est pas le meme",
            'label' => "tape votre mot de passe",
            'required' => true,
            'first_options'=>[
                'label' => "tape votre mot de passe",
                'attr' =>
                [
                    'placeholder' => 'Merci de saisire votre mot de pass'
                ]
                ],   
                'second_options'=>[
                    'label' => "comfirmer mot de passe",
                    'attr' =>
                    [
                        'placeholder' => 'Merci de confirmer votre mot de pass'
                    ]
                    ]                     
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
