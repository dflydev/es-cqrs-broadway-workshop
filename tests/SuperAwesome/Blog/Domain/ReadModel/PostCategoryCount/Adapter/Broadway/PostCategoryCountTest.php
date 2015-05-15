<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\Adapter\Broadway;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\ReadModel\Testing\ReadModelTestCase;
use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCount;

class PostCategoryCountTest extends ReadModelTestCase
{
    /**
     * @return ReadModelInterface
     */
    protected function createReadModel()
    {
        return new PostCategoryCount('drafts', 15);
    }
}
