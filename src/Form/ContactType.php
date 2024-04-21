<?php
namespace App\Form;

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
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class, [
                'attr' => [
                    'class' => 'form-control m-2'
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
                    'class' => 'form-control m-2'
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
                    'class' => 'form-control m-2'
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
                    'class' => 'form-control m-2'
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
                    'class' => 'form-control m-2',
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
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'homepage',
                'locale' => 'fr',
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }

}
