<?php

namespace App\Form;

use App\Entity\Mambra;
use App\Entity\MpitondraRaharaha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MpitondraRaharahaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_sabata')
            ->add('presides', EntityType::class, [
                'class' => Mambra::class,
                'choice_label' => 'nom'
            ])
            ->add('dimy_minitra', EntityType::class, [
                'class' => Mambra::class,
                'choice_label' => 'nom'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MpitondraRaharaha::class,
        ]);
    }
}
