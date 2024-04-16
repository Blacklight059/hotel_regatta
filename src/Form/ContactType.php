<?php
namespace App\Form;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                       'message' => 'Veuillez saisir votre nom'
                    ])
                ]
            ])
            ->add('firstname',TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                       'message' => 'Veuillez saisir votre prénom'
                    ])
                ]
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'E-mail',
                'constraints' => [
                    new NotBlank([
                       'message' => 'Veuillez saisir votre email'
                    ])
                ]
            ])
            ->add('phoneNumber',TelType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Téléphone',
                'constraints' => [
                    new NotBlank([
                       'message' => 'Veuillez saisir votre numéro de téléphone'
                    ])
                ]
            ])
            ->add('message', TextareaType::class, [
                'required' => true, 
                'label' => 'Votre message',
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
            ->add('dateStart', DateType::class, [
                'label' => 'Date du début du séjour',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('dateEnd', DateType::class, [
                'label' => 'Date du fin du séjour',
                'widget' => 'single_text',
                'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('captcha', CaptchaType::class, array(
                'label' => 'Veuillez entrer le texte ci-dessus',
                'width' => 200,
                'height' => 50,
                'length' => 6, // Longueur du CAPTCHA
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

}
