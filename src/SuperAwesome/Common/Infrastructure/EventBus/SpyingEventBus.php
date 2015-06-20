<?php

namespace SuperAwesome\Common\Infrastructure\EventBus;

class SpyingEventBus implements EventBus
{
    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * @var array
     */
    private $recordedEvents = [];

    public function __construct(EventBus $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function subscribe(EventFromBusListener $listener)
    {
        $this->eventBus->subscribe($listener);
    }

    public function publish(array $events)
    {
        $this->eventBus->publish($events);

        foreach ($events as $event) {
            $this->recordedEvents[] = $event;
        }
    }

    public function getRecordedEvents()
    {
        return $this->recordedEvents;
    }

    public function clearRecordedEvents()
    {
        $this->recordedEvents = [];
    }
}
