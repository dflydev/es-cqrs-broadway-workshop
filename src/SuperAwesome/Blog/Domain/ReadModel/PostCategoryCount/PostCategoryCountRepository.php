<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount;

interface PostCategoryCountRepository
{
    /**
     * @param string $category
     *
     * @return PostCategoryCount
     */
    public function find($category);

    /**
     * @return PostCategoryCount[]
     */
    public function findAll();

    /**
     * @param string $tag
     *
     * @return void
     */
    public function increment($category);

    /**
     * @param string $tag
     *
     * @return void
     */
    public function decrement($category);
}
