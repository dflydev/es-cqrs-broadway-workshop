<?php

namespace SuperAwesome\Common\Domain\ReadModel\Adapter\Broadway;

use Broadway\ReadModel\ReadModelInterface;
use Broadway\ReadModel\RepositoryInterface;
use Broadway\Serializer\SerializerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;

class PoorlyDesignedBroadwayDbalRepository implements RepositoryInterface
{
    const TABLE = 'read_models';

    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    private $class;

    /**
     * @param Connection $connection
     */
    public function __construct(
        Connection $connection,
        SerializerInterface $serializer,
        $class
    ) {
        $this->connection = $connection;
        $this->serializer = $serializer;
        $this->class = $class;
    }

    public function save(ReadModelInterface $data)
    {
        $this->connection->delete(static::TABLE, [
            'class' => $this->class,
            'id' => $data->getId(),
        ]);

        $this->connection->insert(static::TABLE, [
            'class' => $this->class,
            'id' => $data->getId(),
            'serialized' => json_encode($this->serializer->serialize($data)),
        ]);
    }

    /**
     * @param string $id
     *
     * @return ReadModelInterface|null
     */
    public function find($id)
    {
        $statement = $this->connection->prepare(
            sprintf('SELECT serialized FROM %s WHERE class = :class AND id = :id', static::TABLE)
        );

        $statement->execute([
            'class' => $this->class,
            'id' => $id,
        ]);

        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return $this->serializer->deserialize(json_decode($row['serialized'], true));
    }

    /**
     * @param array $fields
     *
     * @return ReadModelInterface[]
     */
    public function findBy(array $fields)
    {
        throw new \RuntimeException('Not implemented.');
    }

    /**
     * @return ReadModelInterface[]
     */
    public function findAll()
    {
        $statement = $this->connection->prepare(
            sprintf('SELECT serialized FROM %s WHERE class = :class', static::TABLE)
        );

        $statement->execute([
            'class' => $this->class,
        ]);

        return array_map(function ($row) {
            return $this->serializer->deserialize(json_decode($row['serialized'], true));
        }, $statement->fetchAll(\PDO::FETCH_ASSOC));
    }

    /**
     * @param string $id
     */
    public function remove($id)
    {
        $this->connection->delete(static::TABLE, [
            'class' => $this->class,
            'id' => $id,
        ]);
    }

    /**
     * @return \Doctrine\DBAL\Schema\Table|null
     */
    public static function configureSchema(Schema $schema)
    {
        if ($schema->hasTable(static::TABLE)) {
            return null;
        }

        return static::configureTable();
    }

    public static function configureTable()
    {
        $schema = new Schema();

        $table = $schema->createTable(static::TABLE);

        $table->addColumn('class', 'string');
        $table->addColumn('id', 'string');
        $table->addColumn('serialized', 'text');

        $table->setPrimaryKey(array('class', 'id'));

        return $table;
    }
}
