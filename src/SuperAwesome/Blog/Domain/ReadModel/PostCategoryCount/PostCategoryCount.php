<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount;

use Broadway\ReadModel\Identifiable;
use Broadway\Serializer\Serializable;

class PostCategoryCount implements Identifiable, Serializable
{
    /**
     * @var string
     */
    private $category;

    /**
     * @var int
     */
    private $count;

    /**
     * @param string $category
     * @param int $count
     */
    public function __construct($category, $count)
    {
        $this->category = $category;
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
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
     * @return string
     */
    public function getId(): string
    {
        return $this->category;
    }

    /**
     * @return mixed The object instance
     */
    public static function deserialize(array $data)
    {
        return new static($data['category'], $data['count']);
    }

    /**
     * @return array
     */
    public function serialize(): array
    {
        return [
            'category' => $this->category,
            'count' => $this->count,
        ];
    }
}
