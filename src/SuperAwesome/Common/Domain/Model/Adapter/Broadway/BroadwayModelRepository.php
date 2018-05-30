<?php

namespace SuperAwesome\Common\Domain\Model\Adapter\Broadway;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

trait BroadwayModelRepository
{
    /**
     * Default constructor.
     *
     * @param EventSourcingRepository $eventSourcingRepository
     */
    abstract public function __construct(EventSourcingRepository $eventSourcingRepository);

    /**
     * @param EventStore $eventStore
     * @param EventBus $eventBus
     *
     * @return static
     */
    public static function create(EventStore $eventStore, EventBus $eventBus)
    {
        return new static(self::createEventSourcingRepository($eventStore, $eventBus));
    }

    /**
     * @param EventStore $eventStore
     * @param EventBus $eventBus
     *
     * @return EventSourcingRepository
     */
    private static function createEventSourcingRepository(EventStore $eventStore, EventBus $eventBus)
    {
        $class = static::getAggregateRootClass();

        return new EventSourcingRepository($eventStore, $eventBus, $class, new NamedConstructorAggregateFactory());
    }

    /**
     * @return string
     */
    protected static function getAggregateRootClass()
    {
        throw new \RuntimeException("Broadway Repository requires overriding getAggregateRootClass().");
    }
}
