<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome\Command\Handler;

use PHPUnit_Framework_TestCase as TestCase;
use SuperAwesome\Common\Infrastructure\EventStore\SpyingEventStore;

class PostHandlerScenario
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @var mixed
     */
    private $id = 1;

    public function __construct(TestCase $testCase, SpyingEventStore $eventStore, $commandHandler)
    {
        $this->testCase = $testCase;
        $this->eventStore = $eventStore;
        $this->commandHandler = $commandHandler;
    }

    /**
     * @param $id
     *
     * @return PostHandlerScenario
     */
    public function withId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param array $events
     *
     * @return PostHandlerScenario
     */
    public function given(array $events = [])
    {
        if (! $events) {
            return $this;
        }

        foreach ($events as $event) {
            $this->eventStore->appendEvents($this->id, [$event]);
        }

        $this->eventStore->clearRecordedEvents();

        return $this;
    }

    /**
     * @param mixed $command
     *
     * @return PostHandlerScenario
     */
    public function when($command)
    {
        $this->commandHandler->handle($command);

        return $this;
    }

    /**
     * @param array $events
     *
     * @return PostHandlerScenario
     */
    public function then(array $events = [])
    {
        $this->testCase->assertEquals($events, $this->eventStore->getRecordedEvents());
        $this->eventStore->clearRecordedEvents();

        return $this;
    }
}
