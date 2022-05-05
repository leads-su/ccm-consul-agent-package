<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\AggregateRoots;

use ConsulConfigManager\Consul\Agent\Test\TestCase;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventCollection;

/**
 * Class AbstractAggregateRootTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\AggregateRoots
 */
abstract class AbstractAggregateRootTest extends TestCase
{
    /**
     * Common uuid used for testing
     * @var string
     */
    protected string $uuid;

    /**
     * Check that event has been recorded
     * @param string $eventClass
     * @return bool
     */
    protected function hasEventStored(string $eventClass): bool
    {
        $hasEvent = false;

        /**
         * @var EloquentStoredEventCollection $response
         */
        $response = EloquentStoredEvent::where('aggregate_uuid', '=', $this->uuid)->get();

        if ($response->count() > 0) {
            foreach ($response as $event) {
                if ($event->event_class === $eventClass) {
                    $hasEvent = true;
                    break;
                }
            }
        }

        return $hasEvent;
    }
}
