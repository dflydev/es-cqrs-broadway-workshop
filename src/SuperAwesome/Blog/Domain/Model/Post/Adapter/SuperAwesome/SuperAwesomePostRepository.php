<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome;

use SuperAwesome\Blog\Domain\Model\Post\Post;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;
use SuperAwesome\Common\Infrastructure\EventBus\EventBus;
use SuperAwesome\Common\Infrastructure\EventStore\EventStore;

class SuperAwesomePostRepository implements PostRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;

    /**
     * @var EventBus
     */
    private $eventBus;

    public function __construct(EventStore $eventStore, EventBus $eventBus)
    {
        $this->eventStore = $eventStore;
        $this->eventBus = $eventBus;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $recordedEvents = $this->eventStore->getEvents($id);
        $post = Post::instantiateForReconstitution();
        $post->applyRecordedEvents($recordedEvents);

        return $post;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        throw new \RuntimeException('Not implemeneted. (and will never be implemented!)');
    }

    /**
     * {@inheritdoc}
     */
    public function save(Post $post)
    {
        $recordedEvents = $post->getRecordedEvents();

        $this->eventStore->appendEvents(
            $post->getId(),
            $recordedEvents
        );

        $this->eventBus->publish($recordedEvents);
    }
}
