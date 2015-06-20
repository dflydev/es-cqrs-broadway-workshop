<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome\Command\Handler;

use SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome\SuperAwesomePostRepository;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;
use SuperAwesome\Common\Infrastructure\EventBus\SimpleEventBus;
use SuperAwesome\Common\Infrastructure\EventStore\InMemoryEventStore;
use SuperAwesome\Common\Infrastructure\EventStore\SpyingEventStore;

abstract class AbstractPostHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PostHandlerScenario
     */
    protected $scenario;

    public function setUp()
    {
        $eventStore = new SpyingEventStore(new InMemoryEventStore());
        $eventBus = new SimpleEventBus();
        $postRepository = new SuperAwesomePostRepository($eventStore, $eventBus);

        $this->scenario = new PostHandlerScenario(
            $this,
            $eventStore,
            $this->createCommandHandler($postRepository)
        );
    }

    abstract protected function createCommandHandler(PostRepository $postRepository);
}
