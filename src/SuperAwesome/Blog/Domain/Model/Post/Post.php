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

    private function __construct()
    {
    }

    public static function instantiateForReconstitution()
    {
        return new static();
    }

    public static function create($id)
    {
        $post = new static();
        $post->recordEvent(new PostWasCreated($id));

        return $post;
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
        $this->uncategorizeIfCategoryIsDifferent($category);
        $this->categorizeIfCategoryIsNewOrChanged($category);

        $this->recordEvent(new PostWasPublished($this->id, $title, $content, $category));
    }

    protected function uncategorizeIfCategoryIsDifferent($category)
    {
        if (is_null($this->category) || $this->category === $category) {
            return;
        }

        $this->recordEvent(new PostWasUncategorized($this->id, $this->category));
    }

    protected function categorizeIfCategoryIsNewOrChanged($category)
    {
        if ($this->category === $category) {
            return;
        }

        $this->recordEvent(new PostWasCategorized($this->id, $category));
    }

    protected function applyPostWasPublished(PostWasPublished $event)
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
        if (isset($this->tags[$tag])) {
            return;
        }

        $this->recordEvent(new PostWasTagged($this->id, $tag));
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
        if (! isset($this->tags[$tag])) {
            return;
        }

        $this->recordEvent(new PostWasUntagged($this->id, $tag));
    }

    protected function applyPostWasUntagged(PostWasUntagged $event)
    {
        unset($this->tags[$event->tag]);
    }

    protected function recordEvent($event)
    {
        $this->apply($event);
    }

    public function getAggregateRootId()
    {
        return $this->id;
    }
}
