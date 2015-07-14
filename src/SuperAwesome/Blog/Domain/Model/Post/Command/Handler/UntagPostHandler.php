<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\UntagPost;

class UntagPostHandler extends PostHandler
{
    public function handle(UntagPost $command)
    {
        $post = $this->getPostRepository()->find($command->id);
        $post->removeTag($command->tag);
        $this->getPostRepository()->save($post);
    }
}
