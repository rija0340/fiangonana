<?php
// src/Form/EventListener/AddPrenomFieldSubscriber.php
namespace App\Form\EventListener;

use App\Entity\Famille;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AddNewFamilleFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event): void
    {
        //return entity mambra
        $mambra = $event->getData();
        $form = $event->getForm();
        //mapped false si $mambra n'existe pas cad on va creer un nouveau , et mapped true si edition mambra pour 
        //pouvoir afficher la famille de mambra
        if (null != $mambra->getId()) {
            $form->remove('famille');
            $form->add(
                'famille',
                EntityType::class,
                [
                    'class' => Famille::class,
                    'choice_label' => 'nom',
                    'mapped' => true,
                    'placeholder' => 'choisir famille',
                    'required' => false,
                ]
            );
        } else {
            $form->add(
                'famille',
                EntityType::class,
                [
                    'class' => Famille::class,
                    'choice_label' => 'nom',
                    'mapped' => false,
                    'placeholder' => 'choisir famille',
                    'required' => false,
                ]
            );
        }
    }
}
