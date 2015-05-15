<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost\Adapter\Broadway;

use Broadway\ReadModel\Projector;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPostProjector;

class BroadwayPublishedPostProjector extends Projector
{
    /**
     * @var PublishedPostProjector
     */
    private $projector;

    public function __construct(PublishedPostProjector $projector)
    {
        $this->projector = $projector;
    }

    public function applyPostWasCreated(PostWasCreated $event)
    {
        $this->projector->applyPostWasCreated($event);
    }

    public function applyPostWasPublished(PostWasPublished $event)
    {
        $this->projector->applyPostWasPublished($event);
    }
}
