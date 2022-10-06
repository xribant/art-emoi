<?php

namespace App\Form;

use App\Entity\EventRegistration;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FrontRegistrationType extends AbstractType
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
                    'placeholder' => 'Société si applicable',
                    'class' => 'form-control'
                ]
            ])
            ->add('tva',TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'N° TVA si applicable',
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
            /* ->add('event', EntityType::class, [
                'required' => true,
                'label' => false,
                'class' => Event::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = true')
                        ->orderBy('u.startDate', 'ASC');
                },
                'choice_label' => function($event) {
                        return $event->getWorkshop()->getTitle() . ' du ' . $event->getStartDate()->format('d/m/Y');
                },
                'attr' => [
                    'class' => 'form-control'
                ]
            ]) */
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'homepage'
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
