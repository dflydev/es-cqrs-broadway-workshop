<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount\Adapter\Broadway;

use Broadway\ReadModel\Repository;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCount;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCountRepository;

class BroadwayPostTagCountRepository implements PostTagCountRepository
{
    /**
     * @var Repository
     */
    private $broadwayRepository;

    /**
     * @param Repository $broadwayRepository
     */
    public function __construct(Repository $broadwayRepository)
    {
        $this->broadwayRepository = $broadwayRepository;
    }

    /**
     * @param string $tag
     *
     * @return PostTagCount
     */
    public function find($tag)
    {
        return $this->broadwayRepository->find($tag);
    }

    /**
     * @return PostTagCount[]
     */
    public function findAll()
    {
        return $this->broadwayRepository->findAll();
    }

    /**
     * @param string $tag
     *
     * @return void
     */
    public function increment($tag)
    {
        /** @var PostTagCount $postTagCount */
        $postTagCount = $this->broadwayRepository->find($tag);

        if ($postTagCount) {
            $postTagCount->setCount($postTagCount->getCount() + 1);
        } else {
            $postTagCount = new PostTagCount($tag, 1);
        }

        $this->broadwayRepository->save($postTagCount);
    }

    /**
     * @param string $tag
     *
     * @return void
     */
    public function decrement($tag)
    {
        /** @var PostTagCount $postTagCount */
        $postTagCount = $this->broadwayRepository->find($tag);

        if ($postTagCount) {
            $postTagCount->setCount($postTagCount->getCount() - 1);
        } else {
            $postTagCount = new PostTagCount($tag, 1);
        }

        $this->broadwayRepository->save($postTagCount);
    }
}
