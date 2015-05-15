<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\PublishPost;

class PublishPostHandler extends PostHandler
{
    public function handle(PublishPost $command)
    {
        $post = $this->getPostRepository()->find($command->id);
        $post->publish($command->title, $command->content, $command->category);

        $this->getPostRepository()->save($post);
        // TODO: Implement handle() method.
    }
}
