<?php

namespace ConsulConfigManager\Consul\Agent\Events\Service;

use ConsulConfigManager\Consul\Agent\Events\AbstractEvent;

/**
 * Class ServiceUpdated
 * @package ConsulConfigManager\Consul\Agent\Events\Service
 */
class ServiceUpdated extends AbstractEvent
{
    /**
     * Service configuration array
     * @var array
     */
    private array $configuration;

    /**
     * ServiceUpdated constructor.
     * @param array $configuration
     * @return void
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;
        parent::__construct();
    }

    /**
     * Get service configuration
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
