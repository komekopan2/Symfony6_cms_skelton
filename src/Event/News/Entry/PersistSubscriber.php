<?php

namespace App\Event\News\Entry;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersistSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'news_entry.pre_persist' => 'onPrePersist',
            'news_entry.post_persist' => 'onPostPersist'
        ];
    }

    public function onPrePersist(PrePersistEvent $event)
    {
        // $entry = $event->getEntry();
        // $isCreated = $event->isCreate();
        // 永続化前に何か行う
    }

    public function onPostPersist(PostPersistEvent $event)
    {
        // $entry = $event->getEntry();
        // $isCreated = $event->isCreate();
        // 永続化後に何か行う
    }
}