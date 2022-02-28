<?php

namespace App\Form;

use App\Entity\WorkshopVideo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopVideoType extends AbstractType
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
            ->add('link', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien de la vidéo',
                    'class' => 'form-control'
                ]
            ])
            ->add('description', CKEditorType::class, [
                'required' => true,
                'label' => false,
                'config' => [
                    'toolbar' => 'standard'
                ],
                'attr' => [
                    'placeholder' => 'Description',
                    'class' => 'form-control'
                ]
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkshopVideo::class,
        ]);
    }
}
