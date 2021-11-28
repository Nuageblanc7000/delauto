<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Mark;
use App\Form\ImageType;
use App\Form\getConfigFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AddCarType extends getConfigFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model',TextType::class,$this->getConfig('Model:','entrer votre model'))
            ->add('mark',EntityType::class,$this->getConfig('Marques:', false,
            [
                'class' => Mark::class,
                'choice_label' => 'nameMark'
                ]))
            ->add('km',IntegerType::class,$this->getConfig('Kilométrage:','entrer les km de votre voiture'))
            ->add('price',MoneyType::class,$this->getConfig('Prix:','Entrer votre prix'))
            ->add('fuel',ChoiceType::class,$this->getConfig('Carburant:','diesel',[
               'choices' =>[
                   'Diesel' => 'diesel',
                   'Essence' => 'essence',
                   'LPG' => 'LPG'
               ]
            ]))
            ->add('yearOfEntry',DateType::class,$this->getConfig('Année d\'immatricalution:',false,[
                'widget' => 'single_text'
            ]))
            ->add('numberOwners',IntegerType::class,$this->getConfig('Nombre(s) de propriétaire(s):','5'))
            ->add('enginesize',IntegerType::class,$this->getConfig('Cylindrée','1000'))
            ->add('powerEngine',IntegerType::class,$this->getConfig('Puissance moteur:', '1000'))
            ->add('transmission',ChoiceType::class,$this->getConfig('Transmission:',false,[
                'choices' =>[
                    'Automatique' => 'automatique',
                    'Manuel' => 'manuel'
                ]
             ]))
            ->add('description',TextareaType::class,$this->getConfig('Description:','Ma voiture...'))
            ->add('options',TextType::class,$this->getConfig('Option(s):','gps,volant-chauffant...'))
            ->add('coverImage',UrlType::class,$this->getConfig('Image-Couverture:','https://picsum.photos/200/300'))
        
            ->add('images',CollectionType::class,[
                'entry_type' => ImageType::class,
                'allow_delete' => true,
                'allow_add' => true,

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
