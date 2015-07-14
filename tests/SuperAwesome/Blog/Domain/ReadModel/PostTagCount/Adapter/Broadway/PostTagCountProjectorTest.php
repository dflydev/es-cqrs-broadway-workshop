<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount\Adapter\Broadway;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCount;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCountProjector;

class PostTagCountProjectorTest extends ProjectorScenarioTestCase
{
    /**
     * @return Projector
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        $postRepository = new BroadwayPostTagCountRepository($repository);
        $postTagCountProjector = new PostTagCountProjector($postRepository);

        return new BroadwayPostTagCountProjector($postTagCountProjector);
    }

    /** @test */
    public function it_starts_off_with_one()
    {
        $this->scenario
            ->given([])
            ->when(new PostWasTagged('my-id', 'drafts'))
            ->then([
                new PostTagCount('drafts', 1),
            ])
        ;
    }

    /** @test */
    public function it_returns_to_zero()
    {
        $this->scenario
            ->given([
                new PostWasTagged('my-id', 'drafts'),
            ])
            ->when(new PostWasUntagged('my-id', 'drafts'))
            ->then([
                new PostTagCount('drafts', 0),
            ])
        ;
    }

    /** @test */
    public function it_sums_correctly()
    {
        $this->scenario
            ->given([
                new PostWasTagged('my-id', 'drafts'),
                new PostWasTagged('my-id', 'drafts'),
                new PostWasTagged('my-id', 'drafts'),
            ])
            ->when(new PostWasTagged('my-id', 'drafts'))
            ->then([
                new PostTagCount('drafts', 4),
            ])
        ;
    }

    /** @test */
    public function it_sums_correctly_with_mixed_tags()
    {
        $this->scenario
            ->given([
                new PostWasTagged('my-id', 'drafts'),
                new PostWasTagged('my-id', 'trash'),
                new PostWasTagged('my-id', 'drafts'),
            ])
            ->when(new PostWasTagged('my-id', 'drafts'))
            ->then([
                new PostTagCount('drafts', 3),
                new PostTagCount('trash', 1),
            ])
        ;
    }
}
