<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Karser\Recaptcha3Bundle\Form\Recaptcha3Type;
use Karser\Recaptcha3Bundle\Validator\Constraints\Recaptcha3;
use Symfony\Component\Validator\Constraints\EqualTo;

class AccessCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('key', TextType::class, [
                'constraints' => [
                    new NotBlank(message: 'Veuillez entrer votre code promo pour accéder aux formations'),
                    new EqualTo('DEUILAM2022', message: 'Code invalide')
                ],
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Code d\'accès',
                    'class' => 'form-control'
                ]
            ])
            ->add('captcha', Recaptcha3Type::class, [
                'constraints' => new Recaptcha3(),
                'action_name' => 'homepage'
            ])
        ;
    }
}
