<?php

namespace SuperAwesome\Blog\Domain\ReadModel\TaggedPosts;

use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPostRepository;

class TaggedPostProjector
{
    private $taggedPostRepository;
    private $publishedPostRepository;

    public function __construct(
        TaggedPostRepository $taggedPostRepository,
        PublishedPostRepository $publishedPostRepository
    ) {
        $this->taggedPostRepository = $taggedPostRepository;
        $this->publishedPostRepository = $publishedPostRepository;
    }

    public function applyPostWasTagged(PostWasTagged $event)
    {
        $publishedPost = $this->publishedPostRepository->find($event->id);
        $title = $publishedPost->title;

        $this->taggedPostRepository->create($event->tag, $event->id, $title);
    }

    public function applyPostWasUntagged(PostWasUntagged $event)
    {
        $this->taggedPostRepository->remove($event->tag, $event->id);
    }

    public function applyPostWasPublished(PostWasPublished $event)
    {
        $this->taggedPostRepository->updateTitleForPost($event->id, $event->title);
    }
}
