<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Command\CreatePost;
use SuperAwesome\Blog\Domain\Model\Post\Post;

class CreatePostHandler extends PostHandler
{
    public function handle(CreatePost $command)
    {
        $post = Post::create($command->id);

        $this->getPostRepository()->save($post);
    }
}
