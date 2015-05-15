<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount;

use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;

class PostCategoryCountProjector
{
    /**
     * @var PostCategoryCountRepository
     */
    private $repository;

    public function __construct(PostCategoryCountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function applyPostWasCategorized(PostWasCategorized $event)
    {
        $this->repository->increment($event->category);
    }

    public function applyPostWasUncategorized(PostWasUncategorized $event)
    {
        $this->repository->decrement($event->category);
    }
}
