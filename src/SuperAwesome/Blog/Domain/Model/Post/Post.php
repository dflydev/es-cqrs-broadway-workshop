<?php

namespace SuperAwesome\Blog\Domain\Model\Post;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUntagged;

class Post extends EventSourcedAggregateRoot
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $content;

    /** @var string */
    private $category;

    /** @var bool[] */
    private $tags = [];

    /**
     * @param string $id
     */
    protected function __construct()
    {
    }

    public static function create($id)
    {
        $instance = new self();
        $instance->apply(new PostWasCreated($id));

        return $instance;
    }

    public function applyPostWasCreated(PostWasCreated $event)
    {
        $this->id = $event->id;
    }

    public static function instantiateForReconstitution()
    {
        return new self();
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return array_keys($this->tags);
    }

    /**
     * Publish a post.
     *
     * @param $title
     * @param $content
     * @param $category
     */
    public function publish($title, $content, $category)
    {
        if ($this->category && $this->category !== $category) {
            $this->apply(new PostWasUncategorized($this->id, $this->category));
        }

        if ($this->category !== $category) {
            $this->apply(new PostWasCategorized($this->id, $category));
        }

        $this->apply(new PostWasPublished($this->id, $title, $content, $category));
    }

    public function applyPostWasPublished(PostWasPublished $event)
    {
        $this->category = $event->category;
    }

    /**
     * Tag a post.
     *
     * @param string $tag
     */
    public function addTag($tag)
    {
        if (array_key_exists($tag, $this->tags)) {
            return;
        }

        $this->apply(new PostWasTagged($this->id, $tag));
    }

    public function applyPostWasTagged(PostWasTagged $event)
    {
        $this->tags[$event->tag] = true;
    }

    /**
     * Untag a post.
     *
     * @param string $tag
     */
    public function removeTag($tag)
    {
        if (! isset($this->tags[$tag])) {
            return;
        }

        $this->apply(new PostWasUntagged($this->id, $tag));
    }

    public function applyPostWasUntagged(PostWasUntagged $event)
    {
        if (isset($this->tags[$event->tag])) {
            unset($this->tags[$event->tag]);
        }
    }
}
