<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostTagCount\Adapter\Broadway;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\ReadModel\Testing\ReadModelTestCase;
use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCount;

class PostTagCountTest extends ReadModelTestCase
{
    /**
     * @return ReadModelInterface
     */
    protected function createReadModel()
    {
        return new PostTagCount('broadway', 15);
    }
}
