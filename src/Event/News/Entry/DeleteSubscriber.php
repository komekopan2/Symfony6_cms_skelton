<?php

namespace App\Event\News\Entry;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeleteSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'news_entry.pre_delete' => 'onPreDelete',
            'news_entry.post_delete' => 'onPostDelete'
        ];
    }

    public function onPreDelete(PreDeleteEvent $event)
    {
        // $entry = $event->getEntry();
        // 削除前に何かする
    }

    public function onPostDelete(PostDeleteEvent $event)
    {
        // $entry = $event->getEntry();
        // 削除後に何かする
    }

}