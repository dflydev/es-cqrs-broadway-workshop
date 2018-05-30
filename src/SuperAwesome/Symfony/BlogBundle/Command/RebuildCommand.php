<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use Broadway\Domain\DomainEventStream;
use Broadway\EventDispatcher\EventDispatcher;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\CallableEventVisitor;
use Broadway\EventStore\EventStore;
use Broadway\EventStore\Management\Criteria;
use Broadway\EventStore\Management\EventStoreManagement;
use SuperAwesome\Blog\Domain\Model\Post\Event\PostWasCreated;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RebuildCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('superawesome:blog:rebuild');
        $this->setDescription('Rebuild all the things.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EventStoreManagement $eventStore */
        $eventStore = $this->getContainer()->get('broadway.event_store');

        /** @var EventBus $eventBus */
        $eventBus = $this->getContainer()->get('broadway.event_handling.event_bus');

        $eventStore->visitEvents(
            Criteria::create()->withEventTypes([
                'SuperAwesome.Blog.Domain.Model.Post.Event.PostWasTagged',
                'SuperAwesome.Blog.Domain.Model.Post.Event.PostWasCategorized',
            ]),
            new CallableEventVisitor(function ($event) use ($eventBus) {
                //$eventDispatcher->dispatch()
                //$eventBus->publish(new DomainEventStream([$event]));
                print_r($event->getPayload());
            })
        );

    }
}