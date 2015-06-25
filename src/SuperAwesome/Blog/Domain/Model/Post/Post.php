<?php

namespace SuperAwesome\Blog\Domain\Model\Post;

use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCategorized;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasPublished;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasTagged;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasUncategorized;
use SuperAwesome\Common\Domain\Model\AppliesRecordedEvents;
use SuperAwesome\Common\Domain\Model\EventSourcing;
use SuperAwesome\Common\Domain\Model\RecordsEvents;

class Post implements AppliesRecordedEvents, RecordsEvents
{
    use EventSourcing;

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
    private function __construct()
    {
    }

    public static function create($id)
    {
        $instance = new static();

        $instance->recordEvent(new PostWasCreated($id));

        return $instance;
    }

    public function applyPostWasCreated(PostWasCreated $event)
    {
        $this->id = $event->id;
    }

    public static function instantiateForReconstitution()
    {
        return new static();
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
        $this->uncategorizeIfChanged($category);
        $this->categorizeIfChanged($category);

        if ($this->title == $title && $this->content == $content && $this->category == $category) {
            return;
        }

        $this->recordEvent(new PostWasPublished(
            $this->id,
            $title,
            $content,
            $category
        ));
    }

    protected function applyPostWasPublished(PostWasPublished $event)
    {
        $this->title = $event->title;
        $this->content = $event->content;
        $this->category = $event->category;
    }

    protected function uncategorizeIfChanged($category)
    {
        if (! $this->category) {
            return;
        }

        if ($category != $this->category) {
            $this->recordEvent(new PostWasUncategorized(
                $this->id,
                $this->category
            ));
        }
    }

    protected function categorizeIfChanged($category)
    {
        if (! $this->category || $category != $this->category) {
            $this->recordEvent(new PostWasCategorized(
                $this->id,
                $category
            ));
        }
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

        $this->recordEvent(new PostWasTagged(
            $this->id,
            $tag
        ));
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
        if (isset($this->tags[$tag])) {
            unset($this->tags[$tag]);
        }
    }
}
