<?php

namespace ConsulConfigManager\Consul\Agent\Events\Service;

use ConsulConfigManager\Consul\Agent\Events\AbstractEvent;

/**
 * Class ServiceDeleted
 * @package ConsulConfigManager\Consul\Agent\Events\Service
 */
class ServiceDeleted extends AbstractEvent
{
    /**
     * ServiceDeleted constructor.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
