<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\Get;

use ConsulConfigManager\Consul\Agent\Interfaces\ServiceInterface;

/**
 * Class ServiceGetResponseModel
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\Get
 */
class ServiceGetResponseModel
{
    /**
     * Service model instance
     * @var ServiceInterface|null
     */
    private ?ServiceInterface $serviceEntity;

    /**
     * ServiceResponseModel constructor.
     * @param ServiceInterface|null $serviceEntity
     * @return void
     */
    public function __construct(?ServiceInterface $serviceEntity = null)
    {
        $this->serviceEntity = $serviceEntity;
    }

    /**
     * Get service
     * @return ServiceInterface|null
     */
    public function getService(): ?ServiceInterface
    {
        return $this->serviceEntity;
    }
}
