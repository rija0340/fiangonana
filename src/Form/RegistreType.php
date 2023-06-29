<?php

namespace App\Form;

use App\Entity\Registre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RegistreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', DateType::class, [
                'widget' => 'single_text',
                'required' => true,

            ])
            ->add('mambraTonga')
            ->add('mpamangy')
            ->add('tongaRehetra')
            ->add('nianatraImpito')
            ->add('asafi')
            ->add('asaSoa')
            ->add('fampianaranaBaiboly')
            ->add('bokyTrakta')
            ->add('semineraKaoferansa')
            ->add('alasarona')
            ->add('nahavitaFampTaratasy')
            ->add('batisaTami')
            ->add('fanatitra')
            ->add('kilasy');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Registre::class,
        ]);
    }
}
