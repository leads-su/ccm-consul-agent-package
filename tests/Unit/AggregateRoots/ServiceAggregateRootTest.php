<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\AggregateRoots;

use ConsulConfigManager\Consul\Agent\Events\Service\ServiceCreated;
use ConsulConfigManager\Consul\Agent\Events\Service\ServiceDeleted;
use ConsulConfigManager\Consul\Agent\Events\Service\ServiceUpdated;
use ConsulConfigManager\Consul\Agent\AggregateRoots\ServiceAggregateRoot;

/**
 * Class ServiceAggregateRootTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\AggregateRoots
 */
class ServiceAggregateRootTest extends AbstractAggregateRootTest
{
    /**
     * Common UUID value
     * @var string
     */
    protected string $uuid = 'c1dbd8d3-9547-4d2a-a181-ec035fbaaaed';

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromCreateMethod(array $data): void
    {
        $instance = ServiceAggregateRoot::retrieve($this->uuid)
            ->createEntity($data)
            ->persist();
        $this->assertInstanceOf(ServiceAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ServiceCreated::class));
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromUpdateMethod(array $data): void
    {
        $instance = ServiceAggregateRoot::retrieve($this->uuid)
            ->createEntity($data)
            ->updateEntity([
                'meta'              =>  [
                    'environment'   =>  'production',
                ],
                'port'              =>  32176,
            ])
            ->persist();
        $this->assertInstanceOf(ServiceAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ServiceCreated::class));
        $this->assertTrue($this->hasEventStored(ServiceUpdated::class));
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfInstanceOfAggregateRootIsReturnedFromDeleteMethod(array $data): void
    {
        $instance = ServiceAggregateRoot::retrieve($this->uuid)
            ->createEntity($data)
            ->updateEntity([
                'port'      =>  32176,
            ])
            ->deleteEntity()
            ->persist();
        $this->assertInstanceOf(ServiceAggregateRoot::class, $instance);
        $this->assertTrue($this->hasEventStored(ServiceCreated::class));
        $this->assertTrue($this->hasEventStored(ServiceUpdated::class));
        $this->assertTrue($this->hasEventStored(ServiceDeleted::class));
    }

    /**
     * Entity data provider
     * @return \array[][]
     */
    public function entityDataProvider(): array
    {
        return [
            'ccm-example-127.0.0.1'             =>  [
                'data'                          =>  [
                    'id'                        =>  'ccm-example-127.0.0.1',
                    'service'                   =>  'ccm',
                    'address'                   =>  '127.0.0.1',
                    'port'                      =>  32175,
                    'datacenter'                =>  'dc0',
                    'tags'                      =>  [],
                    'meta'                      =>  [
                        'operating_system'      =>  'linux',
                        'log_level'             =>  'DEBUG',
                        'go_version'            =>  '1.17.2',
                        'environment'           =>  'development',
                        'architecture'          =>  'amd64',
                        'application_version'   =>  '99.9.9',
                    ],
                    'online'                    =>  true,
                ],
            ],
        ];
    }
}
