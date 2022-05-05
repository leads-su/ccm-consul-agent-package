<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\Get;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;

/**
 * Interface ServiceGetOutputPort
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\Get
 */
interface ServiceGetOutputPort
{
    /**
     * Output port for "service information"
     * @param ServiceGetResponseModel $serviceResponseModel
     * @return ViewModel
     */
    public function serviceInformation(ServiceGetResponseModel $serviceResponseModel): ViewModel;

    /**
     * Output port for "service not found"
     * @param ServiceGetResponseModel $serviceResponseModel
     * @return ViewModel
     */
    public function serviceNotFound(ServiceGetResponseModel $serviceResponseModel): ViewModel;

    /**
     * Output port for "internal server error"
     * @param ServiceGetResponseModel $serviceResponseModel
     * @param Throwable $exception
     * @return ViewModel
     *@throws Throwable
     */
    public function internalServerError(ServiceGetResponseModel $serviceResponseModel, Throwable $exception): ViewModel;
}
