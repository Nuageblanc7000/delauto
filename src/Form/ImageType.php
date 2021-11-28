<?php

namespace App\Form;

use App\Entity\Image;
use App\Form\getConfigFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ImageType extends getConfigFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameImg',UrlType::class,$this->getConfig('Mes images:','entrer une url'))
            ->add('caption',TextType::class,$this->getConfig('caption','entrer un petit descriptif de l\'image'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
