<?php

namespace App\Form;

use App\Entity\FreeRegistration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FreeRegistrationType extends AbstractType
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
            ->add('postalCode', TextType::class, [
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
            ->add('workshop', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Formation',
                    'class' => 'form-control'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Prix',
                    'class' => 'form-control'
                ]
            ])
            ->add('tvaRate', TextType::class, [
                'required' => true,
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => '% TVA',
                    'class' => 'form-control',
                    'value' => '21'
                ]
            ])
            ->add('totalHTVA', TextType::class, [
                'required' => true,
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'prix HTVA',
                    'class' => 'form-control',
                    'value' => '0'
                ]
            ])
            ->add('totalTVA', TextType::class, [
                'required' => true,
                'label' => false,
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Montant TVA',
                    'class' => 'form-control',
                    'value' => '0'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FreeRegistration::class,
        ]);
    }
}
