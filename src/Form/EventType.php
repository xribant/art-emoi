<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Workshop;
use App\Entity\WorkshopLocation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
            ->add('location', EntityType::class, [
                'label' => false,
                'class'=> WorkshopLocation::class,
                'choice_label' => 'name',
                'required' => true,
                'attr' => [
                    'class' => 'btn btn-block dropdown-toggle'
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
