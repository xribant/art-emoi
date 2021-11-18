<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Workshop;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
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
            ->add('endDate', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd/MM/yyyy',
                'model_timezone' => 'Europe/Brussels',
                'attr' => [
                    'class' => 'datepicker',
                    'placeholder' => 'Date de fin'
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => '€ 0.00',
                    'class' => 'form-control'
                ]
            ])
            ->add('location', ChoiceType::class, [
                'label' => false,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'Saint-Géry' => 'Saint-Géry',
                    'Lorcé' => 'Lorcé',
                    'Zoom' => 'Zoom'
                ],
                'attr' => [
                    'class' => 'radio'
                ]
            ])
            ->add('workshop', EntityType::class, [
                'class' => Workshop::class,
                'choice_label' => 'title',
                'required' => 'true',
                'label' => false,
                'placeholder' => '',
                'attr' => [
                    'class' => 'btn btn-block dropdown-toggle'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
