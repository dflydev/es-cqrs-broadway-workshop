<?php

namespace SuperAwesome\Common\Domain\Model;

interface RecordsEvents
{
    public function getRecordedEvents();
    public function clearRecordedEvents();
}
