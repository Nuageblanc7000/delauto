<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword',PasswordType::class,[
                'mapped'=>false,
                'label' =>'Ancien password',
                'required'=>true,
                 'constraints' =>[
                     new Assert\NotBlank(['message'=> "votre ancien mot de passe ne peut pas être vide"])
                 ]
            ])
            
            ->add('newPassword',PasswordType::class,[
                'mapped'=>false,
                'required'=>true,
                'constraints' =>[
                    new Assert\NotBlank(['message'=> "votre ancien mot de passe ne peut pas être vide"]),
                    new Assert\Length([
                        'min'=>10,
                        'minMessage'=>"Votre passe doit faire au minium 10 caractère"
                    ])
                ]
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
