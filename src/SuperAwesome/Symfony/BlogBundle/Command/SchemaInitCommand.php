<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\DoctrineCommand;
use SuperAwesome\Common\Domain\ReadModel\Adapter\Broadway\PoorlyDesignedBroadwayDbalRepository;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SchemaInitCommand extends DoctrineCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('superawesome:schema:init')
            ->setDescription('Creates the read model schema')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->getDoctrineConnection('default');

        $error = false;
        try {
            $schemaManager = $connection->getSchemaManager();
            $schema        = $schemaManager->createSchema();

            $table = PoorlyDesignedBroadwayDbalRepository::configureSchema($schema);
            if (null !== $table) {
                $schemaManager->createTable($table);
                $output->writeln('<info>Created poorly designed dbal read model schema</info>');
            } else {
                $output->writeln('<info>Poorly designed dbal read model schema already exists</info>');
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Could not create poorly designed dbal read model schema</error>');
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            $error = true;
        }

        return $error ? 1 : 0;
    }
}
