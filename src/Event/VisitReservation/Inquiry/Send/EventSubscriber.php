<?php
namespace App\Event\VisitReservation\Inquiry\Send;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            PreMailSendEvent::EVENT_NAME => 'onPreMailSend',
            PostMailSendEvent::EVENT_NAME => 'onPostMailSend',
            PostPersistEvent::EVENT_NAME => 'onPostPersist',
        ];
    }
    
    public function onPreMailSend(PreMailSendEvent $event)
    {
        // $inquiry = $event->getInquiry();
        // $form = $event->getForm();
    }
    
    public function onPostMailSend(PostMailSendEvent $event)
    {
        // $inquiry = $event->getInquiry();
        // $form = $event->getForm();
    }
    
    public function onPostPersist(PostPersistEvent $event)
    {
        // $inquiry = $event->getInquiry();
        // $form = $event->getForm();
    }
}