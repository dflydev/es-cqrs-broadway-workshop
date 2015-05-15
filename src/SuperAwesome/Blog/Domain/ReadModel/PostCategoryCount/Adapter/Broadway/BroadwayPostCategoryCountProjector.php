<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\Adapter\Broadway;

use Broadway\ReadModel\Projector;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCountProjector;

class BroadwayPostCategoryCountProjector extends Projector
{
    /**
     * @var PostCategoryCountProjector
     */
    private $projector;

    public function __construct(PostCategoryCountProjector $projector)
    {
        $this->projector = $projector;
    }

    public function applyPostWasCategorized(PostWasCategorized $event)
    {
        $this->projector->applyPostWasCategorized($event);
    }

    public function applyPostWasUncategorized(PostWasUncategorized $event)
    {
        $this->projector->applyPostWasUncategorized($event);
    }
}
