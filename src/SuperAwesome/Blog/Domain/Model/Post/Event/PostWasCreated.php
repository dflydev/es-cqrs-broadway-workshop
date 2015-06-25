<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Event;

use Broadway\Serializer\SerializableInterface;

class PostWasCreated implements SerializableInterface
{
    /**
     * @var string
     */
    public $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['id']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => $this->id,
        ];
    }
}
