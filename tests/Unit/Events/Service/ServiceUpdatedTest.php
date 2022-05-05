<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service;

use ConsulConfigManager\Consul\Agent\Events\Service\ServiceUpdated;

/**
 * Class ServiceUpdatedTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service
 */
class ServiceUpdatedTest extends AbstractServiceEvent
{
    /**
     * @inheritDoc
     */
    protected string $activeEventHandler = ServiceUpdated::class;

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $this->assertInstanceOf(ServiceUpdated::class, $this->createClassInstance($data));
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
    protected function createClassInstance(array $data): ServiceUpdated
    {
        return new $this->activeEventHandler($data);
    }
}
