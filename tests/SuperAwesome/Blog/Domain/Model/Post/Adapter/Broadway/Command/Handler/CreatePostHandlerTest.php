<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\CreatePost;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;

class CreatePostHandlerTest extends AbstractPostHandlerTest
{
    /** @test */
    public function it_can_create()
    {
        $id = 'my-id';

        $this->scenario
            ->when(new CreatePost($id))
            ->then([
                new PostWasCreated($id),
            ])
        ;
    }
}
