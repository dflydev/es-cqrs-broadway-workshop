<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost\Adapter\Broadway;

use Broadway\ReadModel\RepositoryInterface;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPost;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPostRepository;

class BroadwayPublishedPostRepository implements PublishedPostRepository
{
    /**
     * @var RepositoryInterface
     */
    private $broadwayRepository;

    /**
     * @param RepositoryInterface $broadwayRepository
     */
    public function __construct(RepositoryInterface $broadwayRepository)
    {
        $this->broadwayRepository = $broadwayRepository;
    }

    /**
     * @param string $id
     *
     * @return PublishedPost
     */
    public function find($id) {
        return $this->broadwayRepository->find($id);
    }

    /**
     * @return PublishedPost[]
     */
    public function findAll()
    {
        return $this->broadwayRepository->findAll();
    }

    /**
     * @param PublishedPost $publishedPost
     *
     * @return void
     */
    public function save(PublishedPost $publishedPost)
    {
        $this->broadwayRepository->save($publishedPost);
    }
}
