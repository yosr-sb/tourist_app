<?php

namespace App\Form;

use App\Entity\Tour;
use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;

class TourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3])
                ],
                'attr' => ['class' => 'input']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['class' => 'textarea']
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix (€)',
                'currency' => 'EUR',
                'constraints' => [
                    new NotBlank(),
                    new Positive()
                ],
                'attr' => ['class' => 'input']
            ])
            ->add('destination', EntityType::class, [
                'class' => Destination::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une destination...',
                'label' => 'Destination',
                'attr' => ['class' => 'select is-fullwidth']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tour::class,
        ]);
    }
}
