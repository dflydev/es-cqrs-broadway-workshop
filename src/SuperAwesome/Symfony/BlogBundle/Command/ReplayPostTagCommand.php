<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use SuperAwesome\Blog\Domain\Model\Post\Command\TagPost;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReplayPostTagCommand extends CommandBusCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:post:replay-post-tags');
        $this->setDescription('Replay the PostTag ReadModel');

        $this->setDefinition([
            new InputArgument('id', InputArgument::REQUIRED, 'ID for the Post to be replayed'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');

        $eventStore = $this->getContainer()->get('broadway.event_store');

        $eventStream = $eventStore->load($id);

        $tagProjector = $this->getContainer()->get('superawesome.blog.domain.read_model.post_tag_count.projector.broadway');

        foreach ($eventStream as $event) {
            $tagProjector->handle($event);
        }
    }
}
