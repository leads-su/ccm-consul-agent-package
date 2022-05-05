<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\List;

use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServiceListInputPort
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\List
 */
interface ServiceListInputPort
{
    /**
     * Retrieve list of available services
     * @param ServiceListRequestModel $servicesRequestModel
     * @return ViewModel
     */
    public function services(ServiceListRequestModel $servicesRequestModel): ViewModel;
}
