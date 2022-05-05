<?php

namespace ConsulConfigManager\Consul\Agent\Presenters\Service;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Agent\UseCases\Service\Get\ServiceGetOutputPort;
use ConsulConfigManager\Consul\Agent\UseCases\Service\Get\ServiceGetResponseModel;

/**
 * Class ServiceGetHttpPresenter
 * @package ConsulConfigManager\Consul\Agent\Presenters\Service
 */
class ServiceGetHttpPresenter implements ServiceGetOutputPort
{
    /**
     * @inheritDoc
     */
    public function serviceInformation(ServiceGetResponseModel $serviceResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $serviceResponseModel->getService(),
            'Successfully fetched service information',
            Response::HTTP_OK,
        ));
    }

    /**
     * @inheritDoc
     */
    public function serviceNotFound(ServiceGetResponseModel $serviceResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_error(
            [],
            'Unable to find requested service',
            Response::HTTP_NOT_FOUND,
        ));
    }

    // @codeCoverageIgnoreStart
    /**
     * @inheritDoc
     */
    public function internalServerError(ServiceGetResponseModel $serviceResponseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }
        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to retrieve service information'
        ));
    }
    // @codeCoverageIgnoreEnd
}
