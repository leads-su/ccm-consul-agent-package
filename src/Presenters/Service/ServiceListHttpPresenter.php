<?php

namespace ConsulConfigManager\Consul\Agent\Presenters\Service;

use Throwable;
use Illuminate\Http\Response;
use ConsulConfigManager\Domain\Interfaces\ViewModel;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Agent\UseCases\Service\List\ServiceListOutputPort;
use ConsulConfigManager\Consul\Agent\UseCases\Service\List\ServiceListResponseModel;

/**
 * Class ServiceListHttpPresenter
 * @package ConsulConfigManager\Consul\Agent\Presenters\Service
 */
class ServiceListHttpPresenter implements ServiceListOutputPort
{
    /**
     * @inheritDoc
     */
    public function services(ServiceListResponseModel $servicesResponseModel): ViewModel
    {
        return new HttpResponseViewModel(response_success(
            $servicesResponseModel->getCollection()->toArray(),
            'Successfully fetched list of available services',
            Response::HTTP_OK
        ));
    }

    // @codeCoverageIgnoreStart
    /**
     * @inheritDoc
     */
    public function internalServerError(ServiceListResponseModel $serviceResponseModel, Throwable $exception): ViewModel
    {
        if (config('app.debug')) {
            throw $exception;
        }
        return new HttpResponseViewModel(response_error(
            $exception,
            'Unable to list of services'
        ));
    }
    // @codeCoverageIgnoreEnd
}
