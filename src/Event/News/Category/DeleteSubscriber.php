<?php

namespace App\Event\News\Category;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DeleteSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'news_category.pre_delete' => 'onPreDelete',
            'news_category.post_delete' => 'onPostDelete'
        ];
    }

    public function onPreDelete(PreDeleteEvent $event)
    {
        // $category = $event->getCategory();
        // 削除前に何か行う
    }

    public function onPostDelete(PostDeleteEvent $event)
    {
        // $category = $event->getCategory();
        // 削除後に何か行う
    }
}