<?php

namespace App\Form;

use App\Entity\Dessert;
use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Starter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('starter', EntityType::class, [
                'class' => Starter::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('dish', EntityType::class, [
                'class' => Dish::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('dessert', EntityType::class, [
                'class' => Dessert::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
        ]);
    }
}
