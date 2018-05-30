<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount;

use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;

class PostTagCount implements Identifiable, Serializable
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
    public function serialize(): array
    {
        return [
            'tag' => $this->tag,
            'count' => $this->count,
        ];
    }

    /**
     * @return string
     */
    public function getId(): string {
        return (string) $this->tag;
    }
}
