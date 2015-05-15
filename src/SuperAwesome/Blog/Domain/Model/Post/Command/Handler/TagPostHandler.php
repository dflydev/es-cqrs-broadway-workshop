<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\TagPost;

class TagPostHandler extends PostHandler
{
    public function handle(TagPost $command)
    {
        $post = $this->getPostRepository()->find($command->id);
        $post->addTag($command->tag);

        $this->getPostRepository()->save($post);
    }
}
