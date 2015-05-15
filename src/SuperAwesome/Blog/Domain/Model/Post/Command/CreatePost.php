<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command;

class CreatePost
{
    /**
     * @var string
     */
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
}
