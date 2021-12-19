<?php

namespace App\Form;

use App\Entity\EmailNotification;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailNotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Titre',
                    'class' => 'form-control'
                ]
            ])
            ->add('message', CKEditorType::class, [
                'required' => true,
                'label' => false,
                'config' => [
                    'toolbar' => 'full'
                ],
                'attr' => [
                    'placeholder' => 'Message',
                    'class' => 'form-control'
                ]
            ])
            ->add('recipient', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'E-Mail destinataire',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EmailNotification::class,
        ]);
    }
}
