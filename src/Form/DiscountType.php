<?php

namespace App\Form;

use App\Entity\Discount;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Event;

class DiscountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code',
                    'class' => 'form-control'
                ]
            ])
            ->add('rate', NumberType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => '%',
                    'class' => 'form-control'
                ]
            ])
            ->add('enabled', ChoiceType::class,[
                'required' => true,
                'label' => false,
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ]
            ])
            ->add('description', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description',
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
                         ->andWhere('u.startDate > :now')
                         ->setParameter('now', new DateTime())
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discount::class,
        ]);
    }
}
