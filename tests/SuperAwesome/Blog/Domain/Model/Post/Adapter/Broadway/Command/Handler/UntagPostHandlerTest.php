<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\UntagPost;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;

class UntagPostHandlerTest extends AbstractPostHandlerTest
{
    public function setUp()
    {
        $this->markTestIncomplete('Post is not an EventSourcedAggregateRoot.');
    }

    /** @test */
    public function it_can_untag()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $cqrs),
                new PostWasTagged($id, $broadway),
            ])
            ->when(new UntagPost($id, $es))
            ->then([
                new PostWasUntagged($id, $es),
            ])
            ->when(new UntagPost($id, $cqrs))
            ->then([
                new PostWasUntagged($id, $cqrs),
            ])
            ->when(new UntagPost($id, $broadway))
            ->then([
                new PostWasUntagged($id, $broadway),
            ])
        ;
    }

    /** @test */
    public function it_does_not_untag_again()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $cqrs),
                new PostWasTagged($id, $broadway),
                new PostWasUntagged($id, $es),
                new PostWasUntagged($id, $broadway),
            ])
            ->when(new UntagPost($id, $es))
            ->then([
            ])
            ->when(new UntagPost($id, $cqrs))
            ->then([
                new PostWasUntagged($id, $cqrs),
            ])
            ->when(new UntagPost($id, $broadway))
            ->then([
            ])
        ;
    }
}
