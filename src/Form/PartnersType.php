<?php

namespace App\Form;

use App\Entity\Partners;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control'
                ]
            ])
            ->add('lastName', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control'
                ]
            ])
            ->add('email', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-Mail',
                    'class' => 'form-control'
                ]
            ])
            ->add('url', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Site Web',
                    'class' => 'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'form-control'
                ]
            ])
            ->add('country', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                  'Belgique' => 'BE',
                  'France' => 'FR',
                  'Suisse' => 'SW',
                  'Canada' => 'CA'
                ],
                'attr' => [
                    'placeholder' => 'Pays',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
