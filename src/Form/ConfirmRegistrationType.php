<?php

namespace App\Form;

use App\Entity\Discount;
use App\Entity\Event;
use App\Entity\EventRegistration;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class ConfirmRegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $event = $options['event'];

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
            ->add('event', EntityType::class, [
                'required' => true,
                'label' => false,
                'class' => Event::class,
                /* 'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.active = true')
                        ->orderBy('u.startDate', 'ASC');
                }, */
                'choice_label' => function($event) {
                    return $event->getWorkshop()->getTitle().' du '.$event->getStartDate()->format('d/m/Y');
                },
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
                    'class' => 'form-control',
                    'value' => $builder->getData()->getEvent()->getWorkshop()->getWorkshopInfos()->getPrice()
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
            ->add('discount', EntityType::class, [
                'required' => false,
                'label' => false,
                'expanded' => false,
                'multiple' => false,
                'class' => Discount::class,
                'query_builder' => function (EntityRepository $er) use($event) {
                    return $er->createQueryBuilder('d')
                        ->where('d.event = :event')
                        ->setParameters(['event' => $event])
                        ->orderBy('d.id', 'ASC');
                }, 
                'choice_label' => function($discount) {
                    return $discount->getDescription().' - '.$discount->getRate().' €';
                },
                'attr' => [
                    'placeholder' => 'Promo',
                    'class' => 'form-control'
                ]
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventRegistration::class,
            $resolver->setRequired(['event'])
        ]);
    }
}
