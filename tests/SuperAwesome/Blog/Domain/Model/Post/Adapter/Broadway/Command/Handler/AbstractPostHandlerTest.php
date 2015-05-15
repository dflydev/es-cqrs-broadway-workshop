<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway\Command\Handler;

use Broadway\CommandHandling\CommandHandlerInterface;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBusInterface;
use Broadway\EventStore\EventStoreInterface;
use SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway\BroadwayPostCommandHandler;
use SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway\BroadwayPostRepository;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\CreatePostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\PublishPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\TagPostHandler;
use SuperAwesome\Blog\Domain\Model\Post\Command\Handler\UntagPostHandler;

abstract class AbstractPostHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * Create a command handler for the given scenario test case.
     *
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     *
     * @return CommandHandlerInterface
     */
    protected function createCommandHandler(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        $postRepository = BroadwayPostRepository::create($eventStore, $eventBus);

        return new BroadwayPostCommandHandler(
            new CreatePostHandler($postRepository),
            new PublishPostHandler($postRepository),
            new TagPostHandler($postRepository),
            new UntagPostHandler($postRepository)
        );
    }
}
