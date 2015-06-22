<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount;

use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;

class PostTagCountProjector
{
    /**
     * @var PostTagCountRepository
     */
    private $repository;

    public function __construct(PostTagCountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function applyPostWasTagged(PostWasTagged $event)
    {
        $this->repository->increment($event->tag);
    }

    public function applyPostWasUntagged(PostWasUntagged $event)
    {
        $this->repository->decrement($event->tag);
    }
}
