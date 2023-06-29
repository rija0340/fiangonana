<?php

namespace App\Form;

use App\Entity\Kilasy;
use App\Entity\KilasyLasitra;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class KilasyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('kilasy_lasitra', EntityType::class, [
                'class' => KilasyLasitra::class
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Kilasy::class,
        ]);
    }
}
