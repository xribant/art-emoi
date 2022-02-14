<?php

namespace App\Form;

use App\Entity\WorkshopInfos;
use App\Entity\WorkshopLocation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopInfosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('location', EntityType::class, [
                'label' => false,
                'required' => true,
                'expanded' => true,
                'multiple' => true,
                'class' => WorkshopLocation::class,
                'choice_label' => 'name'
            ])
            ->add('duration', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Durée de la formation',
                    'class' => 'form-control',
                ]
            ])
            ->add('start_at', TimeType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'model_timezone' => 'Europe/Brussels',
                'attr' => [
                    'class' => 'timepicker',
                    'placeholder' => 'Heure de début'
                ]
            ])
            ->add('stop_at', TimeType::class, [
                'label' => false,
                'widget' => 'single_text',
                'html5' => false,
                'model_timezone' => 'Europe/Brussels',
                'attr' => [
                    'class' => 'timepicker',
                    'placeholder' => 'Heure de fin'
                ]
            ])
            ->add('price', MoneyType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix',
                    'class' => 'form-control'
                ]
            ])
            ->add('animator', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Animation',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkshopInfos::class,
        ]);
    }
}
