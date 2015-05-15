<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\ReadModel\PostCategoryCount\PostCategoryCountRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostCategoryCountListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:list-category-counts');
        $this->setDescription('List post category counts.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $repository PostCategoryCountRepository */
        $repository = $this->getContainer()->get('superawesome.blog.domain.read_model.post_category_count.repository');

        foreach ($repository->findAll() as $postCategoryCount) {
            $output->writeln(sprintf("%15s%3d", $postCategoryCount->getCategory(), $postCategoryCount->getCount()));
        }
    }
}
