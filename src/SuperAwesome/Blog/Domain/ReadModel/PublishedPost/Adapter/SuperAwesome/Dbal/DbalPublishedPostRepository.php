<?php

namespace SuperAwesome\Blog\Domain\ReadModel\PublishedPost\Adapter\SuperAwesome\Dbal;

use Doctrine\DBAL\Connection;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPost;
use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPostRepository;

class DbalPublishedPostRepository implements PublishedPostRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id)
    {
        $results = array_map([$this, 'unwrapData'], $this->connection->fetchAll(
            'SELECT * FROM published_posts WHERE id = ?',
            [$id]
        ));

        return count($results) ? reset($results) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return array_map([$this, 'unwrapData'], $this->connection->fetchAll(
            'SELECT * FROM published_posts WHERE id = ?'
        ));
    }

    /**
     * @param PublishedPost $publishedPost
     *
     * @return void
     */
    public function save(PublishedPost $publishedPost)
    {
        $data = [
            'title' => $publishedPost->title,
            'content' => $publishedPost->content,
            'category' => $publishedPost->category,
        ];

        try {
            $this->connection->insert('published_posts', array_merge(
                $data,
                ['id' => $publishedPost->id]
            ));
        } catch (\Doctrine\DBAL\DBALException $e) {
            $this->connection->update('published_posts', $data, [
                'id' => $publishedPost->id,
            ]);
        }
    }

    /**
     * @param array $row
     * @return PublishedPost
     */
    protected function unwrapData(array $row)
    {
        return new PublishedPost(
            $row['id'],
            $row['title'],
            $row['content'],
            $row['category']
        );
    }
}
