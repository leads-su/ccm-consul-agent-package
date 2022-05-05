<?php

namespace ConsulConfigManager\Consul\Agent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Agent\UseCases\Service\List\ServiceListInputPort;
use ConsulConfigManager\Consul\Agent\UseCases\Service\List\ServiceListRequestModel;

/**
 * Class ServiceListController
 * @package ConsulConfigManager\Consul\Agent\Http\Controllers
 */
class ServiceListController extends Controller
{
    /**
     * Services interactor instance
     * @var ServiceListInputPort
     */
    private ServiceListInputPort $interactor;

    /**
     * ServicesController constructor.
     * @param ServiceListInputPort $interactor
     * @return void
     */
    public function __construct(ServiceListInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    /**
     * Handle incoming request
     * @param Request $request
     * @return Response|null
     */
    public function __invoke(Request $request): ?Response
    {
        $viewModel = $this->interactor->services(
            new ServiceListRequestModel($request)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }
        return null;
    }

    // @codeCoverageIgnoreEnd
}
