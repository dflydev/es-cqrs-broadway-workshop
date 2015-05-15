<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost;

use Broadway\Serializer\SerializableInterface;

class PublishedPost implements SerializableInterface
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

    /**
     * @param string $id
     */
    public function __construct($id, $title = null, $content = null, $category = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->category = $category;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            $data['id'],
            $data['title'],
            $data['content'],
            $data['category']
        );
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
        ];
    }
}
