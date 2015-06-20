<?php

namespace SuperAwesome\Common\Infrastructure\EventStore;

interface EventStore
{
    public function getEvents($id);
    public function appendEvents($id, array $events);
}
