<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Command;

class PublishPost
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $category;

    public function __construct($id, $title, $content, $category)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
    }
}
