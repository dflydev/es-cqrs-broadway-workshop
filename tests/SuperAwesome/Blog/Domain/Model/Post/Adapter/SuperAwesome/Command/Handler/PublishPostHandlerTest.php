<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\PublishPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\PublishPost;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;

class PublishPostHandlerTest extends AbstractPostHandlerTest
{
    /** @test */
    public function it_can_publish()
    {
        //$this->markTestIncomplete('Post is not an EventSourcedAggregateRoot.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $this->scenario
            ->withId($id)
            ->given([
                new PostWasCreated($id),
            ])
            ->when(new PublishPost($id, $title, $content, $category))
            ->then([
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
        ;
    }

    /** @test */
    public function it_uncategorizes_when_publishing_with_a_different_category()
    {
        //$this->markTestIncomplete('Post is not an EventSourcedAggregateRoot.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'live';

        $originalTitle = 'the original title';
        $originalContent = 'the original content';
        $originalCategory = 'draft';

        $this->scenario
            ->withId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $originalCategory),
                new PostWasPublished($id, $originalTitle, $originalContent, $originalCategory),
            ])
            ->when(new PublishPost($id, $title, $content, $category))
            ->then([
                new PostWasUncategorized($id, $originalCategory),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
        ;
    }

    /** @test */
    public function it_does_not_uncategorize_when_publishing_with_same_category()
    {
        //$this->markTestIncomplete('Post is not an EventSourcedAggregateRoot.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $originalTitle = 'the original title';
        $originalContent = 'the original content';
        $originalCategory = 'draft';

        $this->scenario
            ->withId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $originalCategory),
                new PostWasPublished($id, $originalTitle, $originalContent, $originalCategory),
            ])
            ->when(new PublishPost($id, $title, $content, $category))
            ->then([
                new PostWasPublished($id, $title, $content, $category),
            ])
        ;
    }

    /** @test */
    public function it_does_not_publish_if_nothing_changed()
    {
        //$this->markTestIncomplete('Post is not an EventSourcedAggregateRoot.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $this->scenario
            ->withId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
            ->when(new PublishPost($id, $title, $content, $category))
            ->then([
            ])
        ;
    }

    protected function createCommandHandler(PostRepository $postRepository)
    {
        return new PublishPostHandler($postRepository);
    }
}
