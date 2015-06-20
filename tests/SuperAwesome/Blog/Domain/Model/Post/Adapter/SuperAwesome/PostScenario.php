<?php

namespace SuperAwesome\Blog\Domain\Model\Post\Adapter\SuperAwesome;

use PHPUnit_Framework_TestCase as TestCase;
use SuperAwesome\Blog\Domain\Model\Post\Post;
use SuperAwesome\Common\Domain\Model\AppliesRecordedEvents;
use SuperAwesome\Common\Domain\Model\RecordsEvents;

class PostScenario
{
    /**
     * @var TestCase
     */
    private $testCase;

    /**
     * @var Post|RecordsEvents|AppliesRecordedEvents
     */
    private $post;

    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * @param array $givens
     *
     * @return self
     */
    public function given(array $givens = [])
    {
        if (! $givens) {
            $this->post = null;

            return $this;
        }

        /** @var Post|RecordsEvents|AppliesRecordedEvents $post */
        $post = Post::instantiateForReconstitution();
        $post->applyRecordedEvents($givens);

        $this->post = $post;

        return $this;
    }

    public function when($when)
    {
        if (! is_callable($when)) {
            return $this;
        }

        if ($this->post) {
            $when($this->post);
        } else {
            $this->post = $when(null);
        }

        return $this;
    }

    public function then(array $thens)
    {
        $this->testCase->assertEquals(
            $thens,
            $this->post->getRecordedEvents()
        );

        return $this;
    }
}
