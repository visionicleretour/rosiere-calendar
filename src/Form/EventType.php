<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime as AssertDateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'max' => 120,
                        'minMessage' => 'Votre titre d\'événement doit faire au moins {{ limit }} caractères.',
                        'maxMessage' => 'Votre titre d\'événement doit faire {{ limit }} caractères maximum.'
                    ])
                ]
            ])
            ->add('start', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de début ne peut pas être vide'
                    ])
                ],
                'widget' => 'single_text'
            ])
            ->add('end', DateTimeType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de fin ne peut pas être vide'
                    ])
                ],
                'widget' => 'single_text'
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
