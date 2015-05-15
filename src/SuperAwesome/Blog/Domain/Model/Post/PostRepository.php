<?php

namespace SuperAwesome\Blog\Domain\Model\Post;

interface PostRepository
{
    /**
     * @param string $id
     *
     * @return Post
     */
    public function find($id);

    /**
     * @return Post[]
     */
    public function findAll();

    /**
     * @param Post $post
     */
    public function save(Post $post);
}
