<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service;

use ConsulConfigManager\Consul\Agent\Events\Service\ServiceCreated;

/**
 * Class ServiceCreatedTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service
 */
class ServiceCreatedTest extends AbstractServiceEvent
{
    /**
     * @inheritDoc
     */
    protected string $activeEventHandler = ServiceCreated::class;

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $this->assertInstanceOf(ServiceCreated::class, $this->createClassInstance($data));
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfValidDataReturnedFromGetConfigurationMethod(array $data): void
    {
        $this->assertEquals($data, $this->createClassInstance($data)->getConfiguration());
    }

    /**
     * @inheritDoc
     */
    protected function createClassInstance(array $data): ServiceCreated
    {
        return new $this->activeEventHandler($data);
    }
}
