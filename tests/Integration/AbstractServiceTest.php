<?php

namespace ConsulConfigManager\Consul\Agent\Test\Integration;

use ConsulConfigManager\Consul\Agent\Test\TestCase;
use ConsulConfigManager\Consul\Agent\Services\AbstractService;

/**
 * Class AbstractServiceTest
 * @package ConsulConfigManager\Consul\Agent\Test\Integration
 */
class AbstractServiceTest extends TestCase
{
    /**
     * Class we are currently testing
     * @var AbstractService
     */
    private AbstractService $testedClass;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->testedClass = new class () extends AbstractService {
            public function clientInstance()
            {
                return $this->client();
            }
        };
    }

    public function testShouldPassIfSpecifiedServerIsOnline(): void
    {
        $response = $this->testedClass->serverOnline(
            config('consul.agent.connections.default.host'),
            config('consul.agent.connections.default.port'),
        );
        $this->assertTrue($response);
    }

    public function testShouldPassIfSpecifiedServerIsOffline(): void
    {
        $response = $this->testedClass->serverOnline(
            config('consul.agent.connections.default.host'),
            1234,
        );
        $this->assertFalse($response);
    }
}
