<?php

namespace ConsulConfigManager\Consul\Agent\AggregateRoots;

use ConsulConfigManager\Consul\Agent\Events\Service;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 * Class ServiceAggregateRoot
 * @package ConsulConfigManager\Consul\Agent\AggregateRoots
 */
class ServiceAggregateRoot extends AggregateRoot
{
    /**
     * Handle `create` event
     * @param array $configuration
     * @return $this
     */
    public function createEntity(array $configuration): ServiceAggregateRoot
    {
        $this->recordThat(new Service\ServiceCreated($configuration));
        return $this;
    }

    /**
     * Handle `update` event
     * @param array $configuration
     * @return $this
     */
    public function updateEntity(array $configuration): ServiceAggregateRoot
    {
        $this->recordThat(new Service\ServiceUpdated($configuration));
        return $this;
    }

    /**
     * Handle `delete` event
     * @return $this
     */
    public function deleteEntity(): ServiceAggregateRoot
    {
        $this->recordThat(new Service\ServiceDeleted());
        return $this;
    }
}
