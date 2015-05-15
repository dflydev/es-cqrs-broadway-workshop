<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount\Adapter\Broadway;

use Broadway\ReadModel\Projector;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCountProjector;

class BroadwayPostTagCountProjector extends Projector
{
    /**
     * @var PostTagCountProjector
     */
    private $projector;

    public function __construct(PostTagCountProjector $projector)
    {
        $this->projector = $projector;
    }

    public function applyPostWasTagged(PostWasTagged $event)
    {
        $this->projector->applyPostWasTagged($event);
    }

    public function applyPostWasUntagged(PostWasUntagged $event)
    {
        $this->projector->applyPostWasUntagged($event);
    }
}
