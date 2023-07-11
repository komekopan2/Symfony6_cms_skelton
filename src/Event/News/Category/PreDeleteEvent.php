<?php

namespace App\Event\News\Category;

use App\Entity\News\Category;
use Symfony\Contracts\EventDispatcher\Event;

class PreDeleteEvent extends Event
{
    public function __construct(private readonly Category $category) {}

    public function getCategory(): Category
    {
        return $this->category;
    }
}