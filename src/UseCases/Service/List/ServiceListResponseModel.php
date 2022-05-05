<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\List;

use Illuminate\Support\Collection;

/**
 * Class ServiceListResponseModel
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\List
 */
class ServiceListResponseModel
{
    /**
     * Services collection instance
     * @var Collection|null
     */
    private ?Collection $collection;

    /**
     * ServicesResponseModel constructor.
     * @param Collection|null $collection
     * @return void
     */
    public function __construct(?Collection $collection = null)
    {
        $this->collection = $collection;
    }

    /**
     * Get collection of services
     * @return Collection|null
     */
    public function getCollection(): ?Collection
    {
        return $this->collection;
    }
}
