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
        $publishedPost = new PublishedPost($event->id);

        $this->repository->save($publishedPost);
    }

    public function applyPostWasPublished(PostWasPublished $event)
    {
        $publishedPost = $this->repository->find($event->id);

        $publishedPost->title = $event->title;
        $publishedPost->content = $event->content;
        $publishedPost->category = $event->category;

        $this->repository->save($publishedPost);
    }
}
