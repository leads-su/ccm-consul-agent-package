<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\List;

use Throwable;
use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Agent\Models\Service;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceRepositoryInterface;

/**
 * Class ServiceListInteractor
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\List
 */
class ServiceListInteractor implements ServiceListInputPort
{
    /**
     * Output port instance
     * @var ServiceListOutputPort
     */
    private ServiceListOutputPort $output;

    /**
     * Service repository instance
     * @var ServiceRepositoryInterface
     */
    private ServiceRepositoryInterface $repository;

    /**
     * ServiceInteractor constructor.
     * @param ServiceListOutputPort $output
     * @param ServiceRepositoryInterface $repository
     */
    public function __construct(ServiceListOutputPort $output, ServiceRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function services(ServiceListRequestModel $servicesRequestModel): ViewModel
    {
        try {
            return $this->output->services(new ServiceListResponseModel(
                $this->repository->findManyBy(
                    field: 'service',
                    value: 'ccm'
                )->map(function (Service $service): array {
                    $serviceArray = $service->toArray();
                    $meta = $service->getMeta();
                    Arr::set($serviceArray, 'version', Arr::get($meta, 'application_version'));
                    Arr::forget($serviceArray, 'meta');
                    return Arr::except($serviceArray, [
                        'deleted_at',
                        'tags',
                    ]);
                })
            ));
            // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            return $this->output->internalServerError(new ServiceListResponseModel(), $exception);
        }
        // @codeCoverageIgnoreEnd
    }
}
