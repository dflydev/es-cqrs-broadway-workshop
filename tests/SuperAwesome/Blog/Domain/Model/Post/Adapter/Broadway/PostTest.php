<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway;

use Broadway\EventSourcing\AggregateFactory\AggregateFactoryInterface;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;
use SuperAwesome\Blog\Domain\Model\Post\Post;

class PostTest extends AggregateRootScenarioTestCase
{
    /**
     * Returns a string representing the aggregate root
     *
     * @return string AggregateRoot
     */
    protected function getAggregateRootClass()
    {
        return Post::class;
    }

    /**
     * Returns a factory for instantiating an aggregate
     *
     * @return AggregateFactoryInterface $factory
     */
    protected function getAggregateRootFactory()
    {
        return new NamedConstructorAggregateFactory();
    }

    /** @test */
    public function it_can_create()
    {
        $id = 'my-id';

        $this->scenario
            ->when(function () use ($id) {
                return Post::create($id);
            })
            ->then([
                new PostWasCreated($id),
            ])
        ;
    }

    /** @test */
    public function it_can_publish()
    {
        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
            ])
            ->when(function (Post $post) use ($title, $content, $category) {
                $post->publish($title, $content, $category);
            })
            ->then([
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
        ;
    }

    /** @test */
    public function it_uncategorizes_when_publishing_with_a_different_category()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'live';

        $originalTitle = 'the original title';
        $originalContent = 'the original content';
        $originalCategory = 'draft';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $originalCategory),
                new PostWasPublished($id, $originalTitle, $originalContent, $originalCategory),
            ])
            ->when(function (Post $post) use ($title, $content, $category) {
                $post->publish($title, $content, $category);
            })
            ->then([
                new PostWasUncategorized($id, $originalCategory),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
        ;
    }

    /** @test */
    public function it_does_not_uncategorize_when_publishing_with_same_category()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $originalTitle = 'the original title';
        $originalContent = 'the original content';
        $originalCategory = 'draft';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $originalCategory),
                new PostWasPublished($id, $originalTitle, $originalContent, $originalCategory),
            ])
            ->when(function (Post $post) use ($title, $content, $category) {
                $post->publish($title, $content, $category);
            })
            ->then([
                new PostWasPublished($id, $title, $content, $category),
            ])
        ;
    }

    /** @test */
    public function it_does_not_publish_if_nothing_changed()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
            ->when(function (Post $post) use ($title, $content, $category) {
                $post->publish($title, $content, $category);
            })
            ->then([
            ])
        ;
    }

    /** @test */
    public function it_can_tag()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
            ])
            ->when(function (Post $post) use ($es, $cqrs, $broadway) {
                $post->addTag($es);
                $post->addTag($cqrs);
                $post->addTag($broadway);
            })
            ->then([
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $cqrs),
                new PostWasTagged($id, $broadway),
            ])
        ;
    }

    /** @test */
    public function it_does_not_tag_again()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $broadway),
            ])
            ->when(function (Post $post) use ($es, $cqrs, $broadway) {
                $post->addTag($es);
                $post->addTag($cqrs);
                $post->addTag($broadway);
            })
            ->then([
                new PostWasTagged($id, $cqrs),
            ])
        ;
    }

    /** @test */
    public function it_can_untag()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $cqrs),
                new PostWasTagged($id, $broadway),
            ])
            ->when(function (Post $post) use ($es, $cqrs, $broadway) {
                $post->removeTag($es);
                $post->removeTag($cqrs);
                $post->removeTag($broadway);
            })
            ->then([
                new PostWasUntagged($id, $es),
                new PostWasUntagged($id, $cqrs),
                new PostWasUntagged($id, $broadway),
            ])
        ;
    }

    /** @test */
    public function it_does_not_untag_again()
    {
        $this->markTestIncomplete('Post::instantiateForReconstitution does not exist.');

        $id = 'my-id';
        $title = 'the title';
        $content = 'the content';
        $category = 'draft';

        $es = 'es';
        $cqrs = 'cqrs';
        $broadway = 'broadway';

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new PostWasCreated($id),
                new PostWasCategorized($id, $category),
                new PostWasPublished($id, $title, $content, $category),
                new PostWasTagged($id, $es),
                new PostWasTagged($id, $cqrs),
                new PostWasTagged($id, $broadway),
                new PostWasUntagged($id, $es),
                new PostWasUntagged($id, $broadway),
            ])
            ->when(function (Post $post) use ($es, $cqrs, $broadway) {
                $post->removeTag($es);
                $post->removeTag($cqrs);
                $post->removeTag($broadway);
            })
            ->then([
                new PostWasUntagged($id, $cqrs),
            ])
        ;
    }
}
