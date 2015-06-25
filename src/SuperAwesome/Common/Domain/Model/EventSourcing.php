<?php

namespace SuperAwesome\Common\Domain\Model;

trait EventSourcing
{
    private $recordedEvents = [];

    public function getRecordedEvents()
    {
        return $this->recordedEvents;
    }

    public function clearRecordedEvents()
    {
        $this->recordedEvents = [];
    }

    protected function recordEvent($event)
    {
        $this->handle($event);

        $this->recordedEvents[] = $event;
    }

    public function applyRecordedEvents(array $events)
    {
        foreach ($events as $event) {
            $this->handle($event);
        }
    }

    protected function handle($event)
    {
        $method = $this->getHandleMethod($event);

        if (! method_exists($this, $method)) {
            return;
        }

        $this->$method($event, $event);
    }

    private function getHandleMethod($event)
    {
        $classParts = explode('\\', get_class($event));

        return 'apply' . end($classParts);
    }
}
