<?php

namespace App\Event\News\Entry;

use App\Entity\News\Entry;
use Symfony\Contracts\EventDispatcher\Event;

class PostDeleteEvent extends Event
{
    public function __construct(private readonly Entry $entry) {}

    public function getEntry(): Entry
    {
        return $this->entry;
    }
}