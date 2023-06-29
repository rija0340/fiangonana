<?php

namespace App\Form;

use App\Entity\Cle;
use App\Entity\Hira;
use App\Entity\TypeHira;
use App\Form\TononkiraType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class HiraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'class' => TypeHira::class
            ])
            ->add('titre')
            ->add('numero')
            ->add('cle', EntityType::class, [
                'class' => Cle::class
            ])
            ->add('tononkiras', CollectionType::class, [
                'entry_type' => TononkiraType::class,
                'allow_add' => true,
                'label' => false

            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Hira::class,
        ]);
    }
}
