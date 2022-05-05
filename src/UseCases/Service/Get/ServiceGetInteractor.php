<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\Get;

use Throwable;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceRepositoryInterface;

/**
 * Class ServiceGetInteractor
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\Get
 */
class ServiceGetInteractor implements ServiceGetInputPort
{
    /**
     * Output port instance
     * @var ServiceGetOutputPort
     */
    private ServiceGetOutputPort $output;

    /**
     * Service repository instance
     * @var ServiceRepositoryInterface
     */
    private ServiceRepositoryInterface $repository;

    /**
     * ServiceInteractor constructor.
     * @param ServiceGetOutputPort $output
     * @param ServiceRepositoryInterface $repository
     */
    public function __construct(ServiceGetOutputPort $output, ServiceRepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function service(ServiceGetRequestModel $serviceRequestModel): ViewModel
    {
        $identifier = $serviceRequestModel->getIdentifier();

        try {
            return $this->output->serviceInformation(new ServiceGetResponseModel(
                $this->repository->findOrFail($identifier)
            ));
            // @codeCoverageIgnoreStart
        } catch (Throwable $exception) {
            if ($exception instanceof ModelNotFoundException) {
                return $this->output->serviceNotFound(new ServiceGetResponseModel());
            }
            return $this->output->internalServerError(new ServiceGetResponseModel(), $exception);
        }
        // @codeCoverageIgnoreEnd
    }
}
