<?php

namespace App\Form;

use App\Entity\Room;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title', TextType::class, [
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
            ->add('content', TextareaType::class, [
                'required' => true, 
                'label' => 'Description',
                'constraints' => [
                    new NotBlank([
                       'message' => 'Veuillez saisir votre message'
                    ]),
                    new Length([
                       'min' => 6,
                       'minMessage' => 'Le message doit contenir au minimum {{ limit }} caractères'
                    ]),
                ],
                'attr' => [
                    'class' => 'form-control',
                    'rows' => "10",
                    'cols' => "50",
                ],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix ',
                'row_attr' => [
                    'class' => 'm-3',
                ],
            ])
            ->add('images', FileType::class, [
                'label' => false,
                'mapped' => false,
                "multiple" => true,
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
