<?php

namespace ConsulConfigManager\Consul\Agent\UseCases\Service\Get;

use Illuminate\Http\Request;
use ConsulConfigManager\Users\Interfaces\UserInterface;

/**
 * Class ServiceGetRequestModel
 * @package ConsulConfigManager\Consul\Agent\UseCases\Service\Get
 */
class ServiceGetRequestModel
{
    /**
     * Request instance
     * @var Request
     */
    private Request $request;

    /**
     * Service identifier
     * @var string
     */
    private string $identifier;

    /**
     * ServiceRequestModel constructor.
     * @param Request $request
     * @param string|null $identifier
     */
    public function __construct(Request $request, string $identifier = null)
    {
        $this->request = $request;
        $this->identifier = $identifier;
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
     * Get service identifier
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
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
