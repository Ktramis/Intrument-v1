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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
        ->add('email',EmailType::class,[
            'disabled' => true,
            'label'=>'Mon email',

            
        ])
       
        ->add('firstname',TextType::class,[
            'disabled' => true,
            'label'=>'Mon Prenom',

            ])
        ->add('lastname',TextType::class,[
            'disabled' => true,
            'label'=>'Mon nom',

        ])
        ->add('old_password',PasswordType::class,[
            'label'=>'mon mot de passe actuel',
            'mapped'=>false,
            'attr'=>[
                'placeholder'=>'veuiller saisire'
            ]
        ])
        ->add('new_password',RepeatedType::class,[
            'type'=>  PasswordType::class,
            'mapped' => false,
            'invalid_message' => "le mot des passe n'est pas le meme",
            'label' => "mon nouveau mot de passe",
            'required' => true,
            'first_options'=>[
                'label' => "tape votre nouveau mot de passe",
                'attr' =>
                [
                    'placeholder' => 'Merci de saisire votre mot de pass'
                ]
                ],   
                'second_options'=>[
                    'label' => "comfirmer votre nouveau mot de passe",
                    'attr' =>
                    [
                        'placeholder' => 'Merci de confirmer votre mot de pass'
                    ]
                    ]                     
        ])
        ->add('submit', SubmitType::class, [
            'label' => "Mettre à jour"
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
