<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Tour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomClient', TextType::class, [
                'label' => 'Nom du client',
                'attr' => ['placeholder' => 'Nom complet'],
                'constraints' => [new NotBlank()],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'attr' => ['placeholder' => 'exemple@domaine.com'],
                'constraints' => [new NotBlank(), new Email()],
            ])
            ->add('tour', EntityType::class, [
                'class' => Tour::class,
                'choice_label' => 'title',
                'label' => 'Tour',
                'placeholder' => 'Sélectionnez un tour',
            ])
            ->add('dateReservation', DateTimeType::class, [
                'label' => 'Date de réservation',
                'widget' => 'single_text',
            ])
            ->add('nombrePersonnes', IntegerType::class, [
                'label' => 'Nombre de personnes',
                'attr' => ['min' => 1],
                'constraints' => [new NotBlank(), new Positive()],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
