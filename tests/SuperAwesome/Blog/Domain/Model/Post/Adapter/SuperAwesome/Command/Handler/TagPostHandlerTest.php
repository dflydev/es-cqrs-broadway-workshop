<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\TagPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\TagPost;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;

class TagPostHandlerTest extends AbstractPostHandlerTest
{
    /** @test */
    public function it_can_tag()
    {
        $this->markTestIncomplete('Post cannot be tagged.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
            ->when(new TagPost($id, $es))
            ->then([
                new PostWasTagged($id, $es),
            ])
            ->when(new TagPost($id, $cqrs))
            ->then([
                new PostWasTagged($id, $cqrs),
            ])
            ->when(new TagPost($id, $broadway))
            ->then([
                new PostWasTagged($id, $broadway),
            ])
        ;
    }

    /** @test */
    public function it_does_not_tag_again()
    {
        $this->markTestIncomplete('Post cannot be tagged.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $broadway),
            ])
            ->when(new TagPost($id, $es))
            ->then([
            ])
            ->when(new TagPost($id, $cqrs))
            ->then([
                new PostWasTagged($id, $cqrs),
            ])
            ->when(new TagPost($id, $broadway))
            ->then([
            ])
        ;
    }

    protected function createCommandHandler(PostRepository $postRepository)
    {
        return new TagPostHandler($postRepository);
    }
}
