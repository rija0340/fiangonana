<?php

namespace App\Form;

use App\Entity\HistoriqueHiraChoral;
use App\Service\ApplicationGlobals;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class HistoriqueHiraChoralType extends AbstractType
{

    private $applicationGlobals;
    public function __construct(ApplicationGlobals $applicationGlobals)
    {
        $this->applicationGlobals = $applicationGlobals;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('doneAt', DateType::class, [
                'widget' => 'single_text',
                'required' => false,

            ])
            ->add('fotoana', ChoiceType::class, [
                'choices'  => $this->applicationGlobals->getActiviteChoral(),
            ])
            ->add('hira');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HistoriqueHiraChoral::class,
        ]);
    }
}
