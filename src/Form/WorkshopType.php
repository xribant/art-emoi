<?php

namespace App\Form;

use App\Entity\Workshop;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class WorkshopType extends AbstractType
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
            ->add('description', CKEditorType::class, [
                'label' => false,
                'required' => true,
                'config' => [
                    'toolbar' => 'basic',
                ]
            ])
            ->add('price', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix',
                    'class' => 'form-control',
                ]
            ])
            ->add('location', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lieu de formation',
                    'class' => 'form-control'
                ]
            ])
            ->add('remote', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'selectpicker'
                ],
                'choices' => [
                    'Non' => false,
                    'Oui' => true
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
                'imagine_pattern' => 'workshop_jacket',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}
