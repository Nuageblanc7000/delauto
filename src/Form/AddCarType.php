<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Mark;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AddCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model',TextType::class)
            ->add('km',IntegerType::class)
            ->add('price',MoneyType::class)
            ->add('numberOwners',IntegerType::class)
            ->add('enginesize',IntegerType::class)
            ->add('yearOfEntry',DateType::class)
            ->add('fuel',TextType::class)
            ->add('transmission',TextType::class)
            ->add('description',TextareaType::class)
            ->add('options',TextType::class)
            ->add('coverImage',UrlType::class)
            ->add('powerEngine',IntegerType::class)
            ->add('mark',EntityType::class,[
                'class' => Mark::class,
                'choice_label' => 'nameMark'
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
