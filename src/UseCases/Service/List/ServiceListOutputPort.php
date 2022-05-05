<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\List;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServiceListOutputPort
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\List
 */
interface ServiceListOutputPort
{
    /**
     * Get list of all available services
     * @param ServiceListResponseModel $servicesResponseModel
     * @return ViewModel
     */
    public function services(ServiceListResponseModel $servicesResponseModel): ViewModel;

    /**
     * Handle internal server error
     * @param ServiceListResponseModel $serviceResponseModel
     * @param Throwable $exception
     * @return ViewModel
     *@throws Throwable
     */
    public function internalServerError(ServiceListResponseModel $serviceResponseModel, Throwable $exception): ViewModel;
}
