<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\Model\Post\Command\CreatePost;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreatePostCommand extends CommandBusCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:create');
        $this->setDescription('Create post.');

        $this->setDefinition([
            new InputArgument('id', InputArgument::REQUIRED, 'ID for the new Post'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        $createPost = new CreatePost($id);

        $this->getCommandBus()->dispatch($createPost);
    }
}
