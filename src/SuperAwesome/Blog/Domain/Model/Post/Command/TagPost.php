<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command;

class TagPost
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $tag;

    public function __construct($id, $tag)
    {
        $this->id = $id;
        $this->tag = $tag;
    }
}
