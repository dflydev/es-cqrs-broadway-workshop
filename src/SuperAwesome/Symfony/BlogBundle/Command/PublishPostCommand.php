<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\Model\Post\Command\PublishPost;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PublishPostCommand extends CommandBusCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:publish');
        $this->setDescription('Publish post.');

        $this->setDefinition([
            new InputArgument('id', InputArgument::REQUIRED, 'ID for the Post to be published'),
            new InputArgument('title', InputArgument::REQUIRED, 'Published title'),
            new InputArgument('content', InputArgument::REQUIRED, 'Published content'),
            new InputArgument('category', InputArgument::REQUIRED, 'Published category'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $title = $input->getArgument('title');
        $content = $input->getArgument('content');
        $category = $input->getArgument('category');

        $publishPost = new PublishPost($id, $title, $content, $category);

        $this->getCommandBus()->dispatch($publishPost);
    }
}
