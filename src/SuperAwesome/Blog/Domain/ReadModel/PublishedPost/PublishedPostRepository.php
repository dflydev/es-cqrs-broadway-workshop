<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost;

interface PublishedPostRepository
{
    /**
     * @param string $id
     *
     * @return PublishedPost
     */
    public function find($id);

    /**
     * @return PublishedPost[]
     */
    public function findAll();

    /**
     * @param PublishedPost $publishedPost
     *
     * @return void
     */
    public function save(PublishedPost $publishedPost);
}
