<?php

namespace App\Form;

use App\Entity\HiraChoral;
use App\Entity\ThemeHira;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class HiraChoralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('cle', ChoiceType::class, [
                'choices'  => [
                    '' => '',
                    'A' => 'A',
                    'Ab' => 'Ab',
                    'B' => 'B',
                    'Bb' => 'Bb',
                    'C' => 'C',
                    'Db' => 'Db',
                    'D' => 'D',
                    'Eb' => 'Eb',
                    'E' => 'E',
                    'F' => 'F',
                    'G' => 'G',
                    'Gb' => 'Gb',
                ],
                'required' => false
            ])
            ->add('autheur')
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'required' => false,

            ])
            ->add('theme');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HiraChoral::class,
        ]);
    }
}
