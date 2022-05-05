<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\Get;

use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServiceGetInputPort
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\Get
 */
interface ServiceGetInputPort
{
    /**
     * Get service information
     * @param ServiceGetRequestModel $serviceRequestModel
     * @return ViewModel
     */
    public function service(ServiceGetRequestModel $serviceRequestModel): ViewModel;
}
