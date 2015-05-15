<?php

namespace SuperAwesome\Blog\Domain\Model\Post;

use Broadway\EventSourcing\EventSourcedAggregateRoot;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;

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

    /** @var string */
    private $status;

    /**
     * @param string $id
     */
    private function __construct() { }

    public static function create($id)
    {
        $instance = new static();
        $instance->apply(new PostWasCreated($id));

        return $instance;
    }

    public static function instantiateForReconstitution()
    {
        return new static();
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
        if ($title === $this->title && $content === $this->content && $category === $this->category) {
            return;
        }

        $this->uncategorizeIfCategoryChanged($category);
        $this->categorizeIfCatagoryChanged($category);

        $this->apply(new PostWasPublished(
            $this->id,
            $title,
            $content,
            $category
        ));
    }

    private function categorizeIfCatagoryChanged($category)
    {
        if ($category === $this->category) { return; }

        $this->apply(new PostWasCategorized(
            $this->id,
            $category
        ));
    }

    private function uncategorizeIfCategoryChanged($category)
    {
        if ($category === $this->category || ! $this->category) { return; }

        $this->apply(new PostWasUncategorized(
            $this->id,
            $this->category
        ));
    }

    public function applyPostWasPublished(PostWasPublished $event)
    {
        $this->title = $event->title;
        $this->content = $event->content;
        $this->category = $event->category;

    }

    /**
     * Tag a post.
     *
     * @param string $tag
     */
    public function addTag($tag)
    {
        if (count($this->tags) >= 10) {
            throw new \InvalidArgumentException("Bad tagging.");
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
    public function removeTag($tag) {
        if (isset($this->tags[$tag])) {
            unset($this->tags[$tag]);
        }
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string) $this->id;
    }
}
