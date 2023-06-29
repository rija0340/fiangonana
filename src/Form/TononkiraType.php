<?php

namespace App\Form;

use App\Entity\Tononkira;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TononkiraType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Refrain' => 'refrain',
                    'Tononkira' => 'tononkira',
                ],
                'required' => true
            ])
            ->add('content');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tononkira::class,
        ]);
    }
}
