<?php

namespace App\Form;

use App\Entity\Mambra;
use App\Entity\Famille;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Form\EventListener\AddNewFamilleFieldSubscriber;
use App\Service\ApplicationGlobals;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MambraType extends AbstractType
{

    private $applicationGlobals;
    public function __construct(ApplicationGlobals $applicationGlobals)
    {
        $this->applicationGlobals = $applicationGlobals;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => false,
                'empty_data' => ''
            ])
            ->add('prenom', TextType::class, [
                'required' => true
            ])
            ->add('sexe', ChoiceType::class, [
                'choices'  => [
                    'choisir' => null,
                    'Masculin' => "masculin",
                    'Feminin' => "feminin"
                ],
                'required' => true
            ])
            ->add('trancheAge', ChoiceType::class, [
                'choices'  => $this->applicationGlobals->getTrancheAgeClasse(),
                'required' => false
            ])
            ->add(
                'nouvelle_famille',
                TextType::class,
                [
                    'mapped' => false,
                    'required' => false
                ]
            )
            ->add(
                'baptise'
            )->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'required' => false,


            ]);

        // <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate">

        //override the field famille => mapped : false si mambra exist ( true dans modification d entity mambra)
        $builder->addEventSubscriber(new AddNewFamilleFieldSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mambra::class,
        ]);
    }
}
