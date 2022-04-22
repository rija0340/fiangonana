<?php

namespace App\Form;

use App\Entity\Ville;
use App\Entity\Centre;
use App\Entity\Region;
use App\Entity\Quartier;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CentreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('createdAt')
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'placeholder' => 'Choisir',
                'choice_label' => 'nom'
            ])

            ->add('quartier', EntityType::class, [
                'class' => Quartier::class,
                'placeholder' => 'Choisir',
                'choice_label' => 'nom'
            ]);


        $formModifier = function (FormInterface $form, Region $region = null) {
            $villes = null === $region ? [] : $region->getVilles();

            $form->add('ville', EntityType::class, [
                'class' => Ville::class,
                'placeholder' => 'Choisir',
                'choices' => $villes,
            ]);
        };


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getRegion());
            }
        );


        $builder->get('region')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $region = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $region);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Centre::class,
        ]);
    }
}
