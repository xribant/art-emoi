<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    '' => null,
                    'Formation' => 'Formation',
                    'Atelier' => 'Atelier',
                    'Coaching' => 'Coaching',
                    'Supervision Professionnelle' => 'Supervision'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('title',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('active', ChoiceType::class, [
                'label' => false,
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'attr' => [
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
                    'class' => 'form-control'
                ]
            ])
            ->add('public',ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    '' => null,
                    'Professionnels' => 'pro',
                    'Tous' => 'all',
                    'Certifiés' => 'certified'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label' => false,
                'download_link' => false,
                'download_uri' => false,
                'delete_label' => 'Supprimer l\'image courante',
                'imagine_pattern' => 'product_thumb_resize',
                'attr' => [
                    'class' => 'imageField'
                ]
            ])
            ->add('online', CheckboxType::class, [
                'label' => 'En ligne'
            ])
            ->add('online_price', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ]
            ])
            ->add('visio', CheckboxType::class, [
                'label' => 'Par visioconférence',
            ])
            ->add('visio_price', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ]
            ])
            ->add('present', CheckboxType::class, [
                'label' => 'En présentiel',
            ])
            ->add('present_price', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                ]
            ])
            ->add('rdv', CheckboxType::class, [
                'label' => 'Sur rendez-vous',
            ])
            ->add('trainer',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('video_link',TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Lien vers la vidéo à insérer.  Ex: https://',
                    'class' => 'form-control'
                ]
            ])
            ->add('testimonial', CKEditorType::class, [
                'required' => true,
                'label' => false,
                'config' => [
                    'toolbar' => 'standard'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('hardware_list', CKEditorType::class, [
                'required' => true,
                'label' => false,
                'config' => [
                    'toolbar' => 'standard'
                ],
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
