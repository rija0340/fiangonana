<?php

namespace App\Form;

use App\Entity\Service;
use App\Entity\Direction;
use App\Entity\Personnel;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Form\EventListener\AddPrenomFieldSubscriber;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('direction', EntityType::class, [
                'mapped' => false,
                'class' => Direction::class,
                'choice_label' => 'nom',
                'placeholder' => "choisir"
            ]);


        $builder->get('direction')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                // dd($form->getParent());
                $form->getParent()->add('service', EntityType::class, [
                    'class' => Service::class,
                    'placeholder' => 'Choisir',
                    'choices' => $form->getData()->getServices()
                ]);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $data = $event->getData();
                $service = $data->getService();
                // dd($service); 
                if ($service) {
                    $form->get('direction')->setData($service->getDirection());

                    $form->add('service', EntityType::class, [
                        'class' => Service::class,
                        'placeholder' => 'Choisir',
                        'choices' => $service->getDirection()->getServices()
                    ]);
                } else {
                    $form->add('service', EntityType::class, [
                        'class' => Service::class,
                        'placeholder' => 'Choisir',
                        'choices' => []
                    ]);
                }
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnel::class,
        ]);
    }
}
