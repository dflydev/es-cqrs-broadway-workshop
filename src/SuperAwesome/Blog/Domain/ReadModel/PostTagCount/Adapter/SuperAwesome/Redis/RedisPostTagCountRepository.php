<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount\Adapter\SuperAwesome\Redis;

use Predis\Client;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCount;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCountRepository;

class RedisPostTagCountRepository implements PostTagCountRepository
{
    const KEY = 'post_tag_count';

    private $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    public function increment($tag)
    {
        $this->redis->hincrby(static::KEY, $tag, 1);
    }

    public function decrement($tag)
    {
        $this->redis->hincrby(static::KEY, $tag, -1);
    }

    public function find($tag)
    {
        $count = $this->redis->hget(static::KEY, $tag);
        if (is_null($count)) {
            return null;
        }

        return new PostTagCount($tag, $count);
    }

    public function findAll()
    {
        $results = [];
        foreach ($this->redis->hgetall(static::KEY) as $tag => $count) {
            $results[] = new PostTagCount($tag, $count);
        }

        return $results;
    }
}
