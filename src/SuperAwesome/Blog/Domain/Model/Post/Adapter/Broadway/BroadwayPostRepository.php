<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\Broadway;

use Broadway\EventSourcing\EventSourcingRepository;
use SuperAwesome\Blog\Domain\Model\Post\Post;
use SuperAwesome\Blog\Domain\Model\Post\PostRepository;
use SuperAwesome\Common\Domain\Model\Adapter\BroadwayModelRepository;

class BroadwayPostRepository implements PostRepository
{
    use BroadwayModelRepository;

    /**
     * Default constructor.
     *
     * @param EventSourcingRepository $eventSourcingRepository
     */
    public function __construct(EventSourcingRepository $eventSourcingRepository)
    {
        $this->eventSourcingRepository = $eventSourcingRepository;
    }

    /**
     * @param string $id
     *
     * @return Post
     */
    public function find($id) {
        // TODO: Implement find() method.
    }

    /**
     * @return Post[]
     */
    public function findAll() {
        // TODO: Implement findAll() method.
    }

    /**
     * @param Post $post
     */
    public function save(Post $post) {
        // TODO: Implement save() method.
    }

    protected static function getAggregateRootClass() {
        return Post::class;
    }
}
