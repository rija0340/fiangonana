<?php
// src/Form/EventListener/AddPrenomFieldSubscriber.php
namespace App\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddPrenomFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // Tells the dispatcher that you want to listen on the form.pre_set_data
        // event and that the preSetData method should be called.
        return [FormEvents::PRE_SET_DATA => 'preSetData'];
    }

    public function preSetData(FormEvent $event): void
    {
        //return entity personnel
        $personnel = $event->getData();
        $form = $event->getForm();

        if (!$personnel || null === $personnel->getId()) {
            $form->add('prenom', TextType::class);
        }
    }
}
