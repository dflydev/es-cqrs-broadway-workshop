<?php

namespace SuperAwesome\Common\Infrastructure\EventStore;

class InMemoryEventStore implements EventStore
{
    private $events = array();

    public function getEvents($id)
    {
        $this->ensureEventsAreSetup($id);

        return $this->events[$id];
    }

    public function appendEvents($id, array $events)
    {
        $this->ensureEventsAreSetup($id);

        foreach ($events as $event) {
            $this->events[$id][] = $event;
        }
    }

    private function ensureEventsAreSetup($id)
    {
        if (isset($this->events[$id])) {
            return;
        }

        $this->events[$id] = [];
    }
}
