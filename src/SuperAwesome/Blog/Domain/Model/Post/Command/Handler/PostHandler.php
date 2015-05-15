<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\PostRepository;

abstract class PostHandler
{
    /**
     * @var PostRepository
     */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return PostRepository
     */
    protected function getPostRepository()
    {
        return $this->postRepository;
    }
}
