<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\EventRegistration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                ]
            ])
            ->add('lastName',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                    ]
            ])
            ->add('company',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Société',
                    'class' => 'form-control'
                ]
            ])
            ->add('tva',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'N° TVA',
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                    'required' => true,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'E-Mail',
                        'class' => 'form-control'
                    ]
            ])
            ->add('address', TextType::class, [
                    'required' => true,
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'Rue + Numéro',
                        'class' => 'form-control'
                    ]
            ])
            ->add('postalCode', NumberType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code Postal',
                    'class' => 'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Localité',
                    'class' => 'form-control'
                ]
            ])
            ->add('country', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'Belgique' => 'BE',
                    'France' => 'FR',
                    'Luxembourg' => 'LU',
                    'Suisse' => 'SW',
                    'Canada' => 'CA'
                ],
                'attr' => [
                    'placeholder' => 'Pays',
                    'class' => 'form-control'
                ]
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Téléphone',
                    'class' => 'form-control'
                ]
            ])
            ->add('event', EntityType::class, [
                'required' => true,
                'label' => false,
                'class' => Event::class,
                'choice_label' => function($event) {
                    return $event->getWorkshop()->getTitle().' du '.$event->getStartDate()->format('d/m/Y');
                },
                'attr' => [
                    'placeholder' => 'Formation',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventRegistration::class,
        ]);
    }
}
