<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\CreatePost;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\CreatePostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;

class CreatePostHandlerTest extends AbstractPostHandlerTest
{
    /** @test */
    public function it_can_create()
    {
        $this->markTestIncomplete('Post cannot be created.');

        $id = 'my-id';

        $this->scenario
            ->when(new CreatePost($id))
            ->then([
                new PostWasCreated($id),
            ])
        ;
    }

    protected function createCommandHandler(PostRepository $postRepository)
    {
        return new CreatePostHandler($postRepository);
    }
}
