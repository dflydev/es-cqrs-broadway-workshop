<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Event;

use Broadway\Serializer\SerializableInterface;

class PostWasUncategorized implements SerializableInterface
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $category;

    public function __construct($id, $category)
    {
        $this->id = $id;
        $this->category = $category;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static(
            $data['id'],
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
            'category' => $this->category,
        ];
    }
}
