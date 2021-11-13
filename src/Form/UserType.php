<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-Mail',
                    'class' => 'form-control'
                ]
            ])
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
            ->add('password', RepeatedType::class, [
                'label' => false,
                'required' => true,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mot de passe saisis doivent correspondre',
                'attr' => [
                    'class' => 'form-control form-control-lg form-control-a'
                ],
                'first_options' => [
                    'label' => false,
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
