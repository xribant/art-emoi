<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Product;
use App\Entity\Workshop;
use App\Entity\WorkshopLocation;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
                ],
                'constraints' => [
                    new Constraints\Callback(function($object, ExecutionContextInterface $context) {
                        $start = $context->getRoot()->getData()->getStartDate();
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
            ->add('product', EntityType::class, [
                'label' => false,
                'class' => Product::class,
                'choice_label' => 'title',
                'attr' => [
                    'placeholder' => 'Formation',
                    'class' => 'form-control'
                ]
            ])
            ->add('duration', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Durée',
                    'class' => 'form-control'
                ]
            ])
            ->add('present', ChoiceType::class, [
                'label' => false,
                'expanded' => False,
                'multiple' => false,
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'attr' => [
                    'class' => 'radio'
                ]
            ])
            ->add('location', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
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
