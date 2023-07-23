<?php

namespace App\Form;

use App\Entity\Kilasy;
use App\Entity\KilasyLasitra;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class KilasyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nbrMambra', IntegerType::class, [
                'label' => 'Nombre mambra (optionnel)',
                'required' => false,
            ])
            ->add('nbrMambraUsed', ChoiceType::class, [
                'label' => 'Nombre mambra à utiliser',
                'choices' => [
                    'Mambra registre' => 'registre',
                    'Personnalisé' => 'custom',
                ],
                'expanded' => true,
                'data' => $options['data']->getNbrMambraUsed(), // Set the value from the entity
            ])
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
