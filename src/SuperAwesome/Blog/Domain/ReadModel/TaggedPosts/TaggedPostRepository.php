<?php

namespace SuperAwesome\Blog\Domain\ReadModel\TaggedPosts;

interface TaggedPostRepository
{
    public function create($tag, $postId, $title);
    public function findPostsByTag($tag);
    public function remove($tag, $postId);
    public function updateTitleForPost($postId, $title);
}
