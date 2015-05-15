<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway;

use Broadway\CommandHandling\CommandHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\CreatePost;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\CreatePostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\PublishPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\TagPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\UntagPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\PublishPost;
use SuperAwesome\Blog\Domain\Model\Post\Command\TagPost;
use SuperAwesome\Blog\Domain\Model\Post\Command\UntagPost;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;

class BroadwayPostCommandHandler extends CommandHandler
{
    /**
     * @var CreatePostHandler
     */
    private $createPostHandler;

    /**
     * @var PublishPostHandler
     */
    private $publishPostHandler;

    /**
     * @var TagPostHandler
     */
    private $tagPostHandler;

    /**
     * @var UntagPostHandler
     */
    private $untagPostHandler;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(
        CreatePostHandler $createPostHandler,
        PublishPostHandler $publishPostHandler,
        TagPostHandler $tagPostHandler,
        UntagPostHandler $untagPostHandler
    ) {
        $this->createPostHandler = $createPostHandler;
        $this->publishPostHandler = $publishPostHandler;
        $this->tagPostHandler = $tagPostHandler;
        $this->untagPostHandler = $untagPostHandler;
    }

    /**
     * @param CreatePost $command
     */
    public function handleCreatePost(CreatePost $command)
    {
        $this->createPostHandler->handle($command);
    }

    /**
     * @param PublishPost $command
     */
    public function handlePublishPost(PublishPost $command)
    {
        $this->publishPostHandler->handle($command);
    }

    /**
     * @param TagPost $command
     */
    public function handleTagPost(TagPost $command)
    {
        $this->tagPostHandler->handle($command);
    }

    /**
     * @param UntagPost $command
     */
    public function handleUntagPost(UntagPost $command)
    {
        $this->untagPostHandler->handle($command);
    }
}
