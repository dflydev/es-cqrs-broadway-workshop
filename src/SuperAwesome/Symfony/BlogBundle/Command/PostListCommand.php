<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\ReadModel\PublishedPost\PublishedPostRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:list');
        $this->setDescription('List post category counts.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $repository PublishedPostRepository */
        $repository = $this->getContainer()->get('superawesome.blog.domain.read_model.published_post.repository');

        foreach ($repository->findAll() as $publishedPost) {
            $output->writeln(sprintf("%-15s%-15s%-15s%15s",
                $publishedPost->id,
                $publishedPost->title,
                $publishedPost->content,
                $publishedPost->category
            ));
        }
    }
}
