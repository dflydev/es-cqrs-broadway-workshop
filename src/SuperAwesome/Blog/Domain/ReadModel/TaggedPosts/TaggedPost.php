<?php

namespace SuperAwesome\Blog\Domain\ReadModel\TaggedPosts;

class TaggedPost
{
    public $tag;
    public $postId;
    public $title;
    public function __construct($tag, $postId, $title)
    {
        $this->tag = $tag;
        $this->postId = $postId;
        $this->title = $title;
    }
}
