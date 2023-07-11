<?php

namespace App\Event\News\Category;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersistSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'news_category.pre_persist' => 'onPrePersist',
            'news_category.post_persist' => 'onPostPersist'
        ];
    }

    public function onPrePersist(PrePersistEvent $event) {
        // $category = $event->getCategory();
        // $isCreated = $event->isCreate();
        // 永続化前に何か行う
    }

    public function onPostPersist(PostPersistEvent $event) {
        // $category = $event->getCategory();
        // $isCreate = $event->isCreate();
        // 永続化後に何か行う
    }
}