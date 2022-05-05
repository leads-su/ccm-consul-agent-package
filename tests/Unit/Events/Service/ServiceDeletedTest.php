<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service;

use ConsulConfigManager\Consul\Agent\Events\Service\ServiceDeleted;

/**
 * Class ServiceCreatedTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service
 */
class ServiceDeletedTest extends AbstractServiceEvent
{
    /**
     * @inheritDoc
     */
    protected string $activeEventHandler = ServiceDeleted::class;

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     */
    public function testShouldPassIfEventCanBeCreated(array $data): void
    {
        $this->assertInstanceOf(ServiceDeleted::class, $this->createClassInstance($data));
    }

    /**
     * @inheritDoc
     */
    protected function createClassInstance(array $data): ServiceDeleted
    {
        return new $this->activeEventHandler($data);
    }
}
