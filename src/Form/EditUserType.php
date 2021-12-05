<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class EditUserType extends AbstractType
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
