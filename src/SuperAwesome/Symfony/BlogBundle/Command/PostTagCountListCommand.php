<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\ReadModel\PostTagCount\PostTagCountRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostTagCountListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:list-tag-counts');
        $this->setDescription('List post tag counts.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $repository PostTagCountRepository */
        $repository = $this->getContainer()->get('superawesome.blog.domain.read_model.post_tag_count.repository');

        foreach ($repository->findAll() as $postTagCount) {
            $output->writeln(sprintf("15%s%3d", $postTagCount->getTag(), $postTagCount->getCount()));
        }
    }
}
