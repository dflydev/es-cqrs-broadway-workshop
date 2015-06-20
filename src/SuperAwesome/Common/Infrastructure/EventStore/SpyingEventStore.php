<?php

namespace SuperAwesome\Common\Infrastructure\EventStore;

class SpyingEventStore implements EventStore
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @var array
     */
    private $recordedEvents = [];

    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
    }

    public function getEvents($id)
    {
        return $this->eventStore->getEvents($id);
    }

    public function appendEvents($id, array $events)
    {
        $this->eventStore->appendEvents($id, $events);

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
