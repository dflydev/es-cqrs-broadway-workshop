<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\Serializer\SerializableInterface;

class PostTagCount implements SerializableInterface, ReadModelInterface
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var int
     */
    private $count;

    /**
     * @param string $tag
     * @param int $count
     */
    public function __construct($tag, $count)
    {
        $this->tag = $tag;
        $this->count = $count;
    }

    public function getId()
    {
        return $this->tag;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['tag'], $data['count']);
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'tag' => $this->tag,
            'count' => $this->count,
        ];
    }
}
