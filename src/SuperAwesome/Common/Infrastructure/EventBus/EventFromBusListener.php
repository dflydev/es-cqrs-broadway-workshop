<?php

namespace SuperAwesome\Common\Infrastructure\EventBus;

interface EventFromBusListener
{
    public function handle($event);
}
