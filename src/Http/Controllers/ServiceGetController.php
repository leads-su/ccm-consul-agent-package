<?php

namespace ConsulConfigManager\Consul\Agent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use ConsulConfigManager\Domain\ViewModels\HttpResponseViewModel;
use ConsulConfigManager\Consul\Agent\UseCases\Service\Get\ServiceGetInputPort;
use ConsulConfigManager\Consul\Agent\UseCases\Service\Get\ServiceGetRequestModel;

/**
 * Class ServiceGetController
 * @package ConsulConfigManager\Consul\Agent\Http\Controllers
 */
class ServiceGetController extends Controller
{
    /**
     * Service input port interactor instance
     * @var ServiceGetInputPort
     */
    private ServiceGetInputPort $interactor;

    /**
     * ServiceController constructor.
     * @param ServiceGetInputPort $interactor
     * @return void
     */
    public function __construct(ServiceGetInputPort $interactor)
    {
        $this->interactor = $interactor;
    }

    // @codeCoverageIgnoreStart

    /**
     * Handle incoming request
     * @param Request $request
     * @param string $identifier
     * @return Response|null
     */
    public function __invoke(Request $request, string $identifier): ?Response
    {
        $viewModel = $this->interactor->service(
            new ServiceGetRequestModel($request, $identifier)
        );

        if ($viewModel instanceof HttpResponseViewModel) {
            return $viewModel->getResponse();
        }

        return null;
    }

    // @codeCoverageIgnoreEnd
}
