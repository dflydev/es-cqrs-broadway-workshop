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

    /** @var string */
    private $status;

    public function getAggregateRootId()
    {
        return $this->id;
    }

    public function instantiateForReconstitution()
    {
        return new Post;
    }

    public static function create($id)
    {
        $inst = new self;
        $inst->apply(new PostWasCreated($id));

        return $inst;
    }

    public function applyPostWasCreated($event)
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
        if ($this->category != $category) {
            if ($this->category) {
                $this->apply(new PostWasUncategorized($this->id, $this->category));
            }
            $this->apply(new PostWasCategorized($this->id, $category));
        }

        if ($title == $this->title && $content == $this->content && $category == $this->category) {
            return;
        }

        $this->apply(new PostWasPublished($this->id, $title, $content, $category));
    }

    public function applyPostWasPublished($event)
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
        if (isset($this->tags[$tag])) {
            return;
        }

        $this->apply(new PostWasTagged($this->id, $tag));
    }

    public function applyPostWasTagged($event)
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
        $this->apply(new PostWasUntagged($this->id, $tag));
    }

    public function applyPostWasUntagged($event)
    {
        unset($this->tags[$event->tag]);
    }
}
