<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\Model\Post\Command\UntagPost;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UntagPostCommand extends CommandBusCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:untag');
        $this->setDescription('Untag a post.');

        $this->setDefinition([
            new InputArgument('id', InputArgument::REQUIRED, 'ID for the Post to be untagged'),
            new InputArgument('tag', InputArgument::REQUIRED, 'Tag'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $tag = $input->getArgument('tag');

        $command = new UntagPost($id, $tag);
        $this->getCommandBus()->dispatch($command);
    }
}
