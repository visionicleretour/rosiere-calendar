<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'readonly' => true
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Votre nom de famille doit faire au moins {{ limit }} caractères.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
