<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount;

interface PostTagCountRepository
{
    /**
     * @param string $tag
     *
     * @return PostTagCount
     */
    public function find($tag);

    /**
     * @return PostTagCount[]
     */
    public function findAll();

    /**
     * @param string $tag
     *
     * @return void
     */
    public function increment($tag);

    /**
     * @param string $tag
     *
     * @return void
     */
    public function decrement($tag);
}
