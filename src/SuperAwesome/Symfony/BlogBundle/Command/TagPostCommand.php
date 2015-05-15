<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\Model\Post\Command\TagPost;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TagPostCommand extends CommandBusCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:tag');
        $this->setDescription('Tag a post.');

        $this->setDefinition([
            new InputArgument('id', InputArgument::REQUIRED, 'ID for the Post to be tagged'),
            new InputArgument('tag', InputArgument::REQUIRED, 'Tag'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $tag = $input->getArgument('tag');

        $tagPost = new TagPost($id, $tag);

        $this->getCommandBus()->dispatch($tagPost);
    }
}
