<?php

namespace App\Form;

use App\Entity\Dessert;
use App\Entity\Dish;
use App\Entity\Menu;
use App\Entity\Starter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class MenuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'required' => true, 
            'label' => 'Titre',
            'constraints' => [
                new NotBlank([
                'message' => "Veuillez saisir un nom"
                ]),
                new Length([
                'min' => 6,
                'minMessage' => "Le titre doit contenir au minimum {{ limit }} caractères"
                ]),
            ],
            'row_attr' => [
                'class' => 'm-3',
            ],
        ])            
        ->add('price', MoneyType::class, [
            'label' => 'Prix',
            'row_attr' => [
                'class' => 'm-3',
            ],
        ])
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
