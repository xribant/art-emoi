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
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

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
                    'Formation' => 'training',
                    'Atelier' => 'workshop',
                    'Coaching' => 'Coaching',
                    'Supervision Professionnelle' => 'supervision'
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
            ->add('start_at', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'model_timezone' => 'Europe/Brussels',
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'Date de début'
                ]
            ])
            ->add('end_at', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'model_timezone' => 'Europe/Brussels',
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'Date de fin'
                ],
                'constraints' => [
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData()->getStartAt();
                        $stop = $object;

                        if (is_a($start, \DateTime::class) && is_a($stop, \DateTime::class)) {
                            if ($stop->format('U') - $start->format('U') < 0) {
                                $context
                                    ->buildViolation('La date de fin doit être postérieure à la date de début')
                                    ->addViolation();
                            }
                        }
                    })
                ]
            ])
            ->add('nbr_sessions',TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control'
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
            ->add('present_location',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Lieu',
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
