<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\Adapter\Broadway;

use Broadway\ReadModel\Repository;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCount;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCountRepository;

class BroadwayPostCategoryCountRepository implements PostCategoryCountRepository
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
     * @param string $category
     *
     * @return PostCategoryCount
     */
    public function find($category)
    {
        return $this->broadwayRepository->find($category);
    }

    /**
     * @return PostCategoryCount[]
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
    public function increment($category)
    {
        /** @var PostCategoryCount $postCategoryCount */
        $postCategoryCount = $this->broadwayRepository->find($category);

        if ($postCategoryCount) {
            $postCategoryCount->setCount($postCategoryCount->getCount() + 1);
        } else {
            $postCategoryCount = new PostCategoryCount($category, 1);
        }

        $this->broadwayRepository->save($postCategoryCount);
    }

    /**
     * @param string $tag
     *
     * @return void
     */
    public function decrement($category)
    {
        /** @var PostCategoryCount $postCategoryCount */
        $postCategoryCount = $this->broadwayRepository->find($category);

        if ($postCategoryCount) {
            $postCategoryCount->setCount($postCategoryCount->getCount() - 1);
        } else {
            $postCategoryCount = new PostCategoryCount($category, 1);
        }

        $this->broadwayRepository->save($postCategoryCount);
    }
}
