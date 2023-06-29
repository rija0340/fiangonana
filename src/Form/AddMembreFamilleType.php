<?php

namespace App\Form;

use App\Entity\Mambra;
use App\Service\ApplicationGlobals;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AddMembreFamilleType extends AbstractType
{

    private $applicationGlobals;
    public function __construct(ApplicationGlobals $applicationGlobals)
    {
        $this->applicationGlobals = $applicationGlobals;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('baptise')
            ->add('trancheAge', ChoiceType::class, [
                'choices'  => $this->applicationGlobals->getTrancheAgeClasse(),
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
