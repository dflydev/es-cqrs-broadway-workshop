<?php

namespace SuperAwesome\Symfony\BlogBundle\Command;

use Broadway\CommandHandling\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

abstract class CommandBusCommand extends ContainerAwareCommand
{
    /**
     * @return CommandBusInterface
     */
    protected function getCommandBus()
    {
        return $this->getContainer()->get('broadway.command_handling.command_bus');
    }
}
