<?php

namespace SuperAwesome\Common\Infrastructure\EventBus;

interface EventBus
{
    public function subscribe(EventFromBusListener $listener);
    public function publish(array $events);
}
