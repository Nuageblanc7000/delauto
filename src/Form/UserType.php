<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname',TextType::class,[
            'label'=>'Nom:',
             'attr'=>[
                 'placeholder'=>'Doe'
             ]
        ])
        ->add('firstname',TextType::class,[
                'label'=>'Prénom:',
                'attr' =>[
                    'placeholder'=>'Jhon',        
                ]
            
        ])
            ->add('email',EmailType::class)
            ->add('picture',UrlType::class,[
                'required'=>false
                ])
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'le password ne correspond pas',
                'options' =>[
                    'attr' => ['class' =>'password']
                ],
                'first_options' => ['label' =>'mot de passe:', 'attr'=>['placeholder'=>"entrer votre mot de passe"]],
                'second_options' => ['label' => 'confirmer:', 'attr'=>['placeholder'=>"confirmer votre pass"] ]
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
