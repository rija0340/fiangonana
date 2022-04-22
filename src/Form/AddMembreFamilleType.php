<?php

namespace App\Form;

use App\Entity\Mambra;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddMembreFamilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('baptise')
            ->add('trancheAge', ChoiceType::class, [
                'choices'  => [
                    'choisir' => null,
                    "0 à 2" =>  '0_2',
                    "3 à 4" =>  '3_4',
                    "5 à 12" => '5_12',
                    "13 à 15" => '13_15',
                    "16 à 18" => '16_18',
                    "19 à 35" => '19_35',
                    "Plus de 35" =>  '35+',
                ],
                'required' => false
            ])
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'choisir' => null,
                    'Masculin' => "masculin",
                    'Feminin' => "feminin"
                ],
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mambra::class,
        ]);
    }
}
