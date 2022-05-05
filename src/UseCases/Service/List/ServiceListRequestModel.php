<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\List;

use Illuminate\Http\Request;
use ConsulConfigManager\Users\Interfaces\UserInterface;

/**
 * Class ServiceListRequestModel
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\List
 */
class ServiceListRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * ServiceRequestModel constructor.
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get request instance
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Get user who made this request
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface
    {
        return $this->getRequest()->user();
    }
}
