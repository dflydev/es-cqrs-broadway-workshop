<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost\Adapter\Broadway;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\ReadModel\Testing\ReadModelTestCase;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPost;

class PublishedPostTest extends ReadModelTestCase
{
    /**
     * @return ReadModelInterface
     */
    protected function createReadModel()
    {
        return new PublishedPost(
            'post-id',
            'published title',
            'published content',
            'drafts'
        );
    }
}
