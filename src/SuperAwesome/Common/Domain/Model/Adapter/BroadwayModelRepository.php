<?php

namespace SuperAwesome\Common\Domain\Model\Adapter;

use Broadway\EventHandling\EventBusInterface;
use Broadway\EventSourcing\AggregateFactory\NamedConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStoreInterface;

trait BroadwayModelRepository
{
    /**
     * Default constructor.
     *
     * @param EventSourcingRepository $eventSourcingRepository
     */
    abstract public function __construct(EventSourcingRepository $eventSourcingRepository);

    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     *
     * @return static
     */
    public static function create(EventStoreInterface $eventStore, EventBusInterface $eventBus)
    {
        return new static(self::createEventSourcingRepository($eventStore, $eventBus));
    }

    /**
     * @param EventStoreInterface $eventStore
     * @param EventBusInterface $eventBus
     *
     * @return EventSourcingRepository
     */
    private static function createEventSourcingRepository(EventStoreInterface $eventStore, EventBusInterface $eventBus)
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
