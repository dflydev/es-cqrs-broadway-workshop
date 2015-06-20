<?php

namespace SuperAwesome\Common\Infrastructure\EventBus;

class SimpleEventBus implements EventBus
{
    /**
     * @var EventFromBusListener[]
     */
    private $listeners = [];

    public function subscribe(EventFromBusListener $listener)
    {
        $this->listeners[] = $listener;
    }

    public function publish(array $events)
    {
        foreach ($events as $event) {
            foreach ($this->listeners as $listener) {
                $listener->handle($event);
            }
        }
    }
}
