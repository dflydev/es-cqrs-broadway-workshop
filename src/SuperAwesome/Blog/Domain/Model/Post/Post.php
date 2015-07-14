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
    private function __construct()
    {
    }

    public static function create($id)
    {
        $instance = new self();
        $instance->apply(new PostWasCreated($id));

        return $instance;
    }

    public static function instantiateForReconstitution()
    {
        return new self();
    }

    protected function applyPostWasCreated(PostWasCreated $event)
    {
        $this->id = $event->id;
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
        if ($this->title === $title && $this->content === $content && $this->category === $category) {
            return;
        }

        $this->uncategorizeIfCategoryChanged($category);
        $this->categorizeIfCategoryChanged($category);

        $this->apply(new PostWasPublished($this->id, $title, $content, $category));
    }

    protected function applyPostWasPublished(PostWasPublished $event)
    {
        $this->title = $event->title;
        $this->content = $event->content;
        $this->category = $event->category;
    }

    private function uncategorizeIfCategoryChanged($category)
    {
        if (is_null($this->category) || $this->category === $category) {
            return;
        }

        $this->apply(new PostWasUncategorized($this->id, $this->category));
    }

    private function categorizeIfCategoryChanged($category)
    {
        if ($this->category === $category) {
            return;
        }

        $this->apply(new PostWasCategorized($this->id, $category));
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

    protected function applyPostWasTagged(PostWasTagged $event)
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
        if (! array_key_exists($tag, $this->tags)) {
            return;
        }

        $this->apply(new PostWasUntagged($this->id, $tag));
    }

    protected function applyPostWasUntagged(PostWasUntagged $event)
    {
        unset($this->tags[$event->tag]);
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string) $this->id;
    }
}
