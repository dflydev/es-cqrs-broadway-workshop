<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost;


use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;

class PublishedPostProjector
{
    /**
     * @var PublishedPostRepository
     */
    private $repository;

    public function __construct(PublishedPostRepository $repository)
    {
        $this->repository = $repository;
    }

    public function applyPostWasCreated(PostWasCreated $event)
    {
        // @TODO Implement
    }

    public function applyPostWasPublished(PostWasPublished $event)
    {
        // @TODO Implement
    }
}
