<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\Adapter\Broadway;

use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCount;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCountProjector;

class PostCategoryCountProjectorTest extends ProjectorScenarioTestCase
{
    /**
     * @return Projector
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        $postRepository = new BroadwayPostCategoryCountRepository($repository);
        $postCategoryCountProjector = new PostCategoryCountProjector($postRepository);

        return new BroadwayPostCategoryCountProjector($postCategoryCountProjector);
    }

    /** @test */
    public function it_starts_off_with_one()
    {
        $this->scenario
            ->given([])
            ->when(new PostWasCategorized('my-id', 'drafts'))
            ->then([
                new PostCategoryCount('drafts', 1),
            ])
        ;
    }

    /** @test */
    public function it_returns_to_zero()
    {
        $this->scenario
            ->given([
                new PostWasCategorized('my-id', 'drafts'),
            ])
            ->when(new PostWasUncategorized('my-id', 'drafts'))
            ->then([
                new PostCategoryCount('drafts', 0),
            ])
        ;
    }

    /** @test */
    public function it_sums_correctly()
    {
        $this->scenario
            ->given([
                new PostWasCategorized('my-id', 'drafts'),
                new PostWasCategorized('my-id', 'drafts'),
                new PostWasCategorized('my-id', 'drafts'),
            ])
            ->when(new PostWasCategorized('my-id', 'drafts'))
            ->then([
                new PostCategoryCount('drafts', 4),
            ])
        ;
    }

    /** @test */
    public function it_sums_correctly_with_different_ids()
    {
        $this->scenario
            ->given([
                new PostWasCategorized('my-id', 'drafts'),
                new PostWasCategorized('foo', 'drafts'),
                new PostWasCategorized('my-id', 'drafts'),
            ])
            ->when(new PostWasCategorized('my-id', 'drafts'))
            ->then([
                new PostCategoryCount('drafts', 4),
            ])
        ;
    }

    /** @test */
    public function it_sums_correctly_with_different_tags()
    {
        $this->scenario
            ->given([
                new PostWasCategorized('my-id', 'drafts'),
                new PostWasCategorized('my-id', 'trash'),
                new PostWasCategorized('my-id', 'drafts'),
            ])
            ->when(new PostWasCategorized('my-id', 'drafts'))
            ->then([
                new PostCategoryCount('drafts', 3),
                new PostCategoryCount('trash', 1),
            ])
        ;
    }
}
