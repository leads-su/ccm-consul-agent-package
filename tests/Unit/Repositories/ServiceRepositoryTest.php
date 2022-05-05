<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Repositories;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Agent\Models\Service;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceRepositoryInterface;

/**
 * Class ServiceRepositoryTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Repositories
 */
class ServiceRepositoryTest extends AbstractRepositoryTest
{
    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfCanCreateNewEntry(array $data): void
    {
        $entity = $this->repository()->create($data);
        $this->assertSameReturned($entity, $data);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfCanUpdateEntry(array $data): void
    {
        $entity = $this->repository()->create($data);
        $this->assertSameReturned($entity, $data);

        Arr::set($data, 'port', 32176);
        $entity = $this->repository()->update($data);
        $this->assertSameReturned($entity, $data);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfCanDeleteExistingEntry(array $data): void
    {
        $entity = $this->repository()->create($data);
        $this->assertSameReturned($entity, $data);

        $response = $this->repository()->delete($entity->getIdentifier());
        $this->assertTrue($response);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromAllRequest(array $data): void
    {
        $this->repository()->create($data);
        $response = $this->repository()->all();
        $this->assertSameReturned($response->first(), $data);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindRequest(array $data): void
    {
        $this->repository()->create($data);
        $response = $this->repository()->find(Arr::get($data, 'id'));
        $this->assertSameReturned($response, $data);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfValidDataReturnedFromFindOrFailRequest(array $data): void
    {
        $this->repository()->create($data);
        $response = $this->repository()->findOrFail('ccm-example-127.0.0.1');
        $this->assertSameReturned($response, $data);
    }

    /**
     * @return void
     */
    public function testShouldPassIfExceptionIsThrownOnModelNotFoundFromFindOrFailRequest(): void
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository()->findOrFail('ccm-example-127.0.0.2');
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfTrueReturnedFromDeleteMethod(array $data): void
    {
        $this->repository()->create($data);
        $response = $this->repository()->delete(Arr::get($data, 'id'));
        $this->assertTrue($response);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfFalseReturnedFromDeleteMethod(array $data): void
    {
        $response = $this->repository()->delete(Arr::get($data, 'id'));
        $this->assertFalse($response);
    }

    /**
     * @param array $data
     * @dataProvider entityDataProvider
     * @return void
     */
    public function testShouldPassIfTrueReturnedFromForceDeleteMethod(array $data): void
    {
        $this->repository()->create($data);
        $response = $this->repository()->forceDelete(Arr::get($data, 'id'));
        $this->assertTrue($response);
    }


    /**
     * Create new repository instance
     * @return ServiceRepositoryInterface
     */
    private function repository(): ServiceRepositoryInterface
    {
        return $this->app->make(ServiceRepositoryInterface::class);
    }

    /**
     * Assert that data returned is the same as in array
     * @param Service $entity
     * @param array $data
     * @return void
     */
    private function assertSameReturned(Service $entity, array $data)
    {
        $this->assertInstanceOf(Service::class, $entity);
        $this->assertArrayHasKey('id', $entity);
        $this->assertArrayHasKey('uuid', $entity);
        $this->assertSame(Arr::get($data, 'id'), $entity->getIdentifier());
        $this->assertSame(Arr::get($data, 'service'), $entity->getService());
        $this->assertSame(Arr::get($data, 'address'), $entity->getAddress());
        $this->assertSame(Arr::get($data, 'port'), $entity->getPort());
        $this->assertSame(Arr::get($data, 'datacenter'), $entity->getDatacenter());
        $this->assertSame(Arr::get($data, 'tags'), $entity->getTags());
        $this->assertSame(Arr::get($data, 'meta'), $entity->getMeta());
        $this->assertSame(Arr::get($data, 'online'), $entity->isOnline());
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
