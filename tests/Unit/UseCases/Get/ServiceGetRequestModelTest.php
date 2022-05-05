<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\UseCases\Get;

use ConsulConfigManager\Consul\Agent\Test\TestCase;
use ConsulConfigManager\Consul\Agent\UseCases\Service\Get\ServiceGetRequestModel;

/**
 * Class ServiceListRequestModelTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\UseCases\List
 */
class ServiceGetRequestModelTest extends TestCase
{
    public function testShouldPassIfInstanceOfRequestIsReturned(): void
    {
        $request = request();
        $identifier = 'example';
        $instance = new ServiceGetRequestModel($request, $identifier);
        $this->assertSame($request, $instance->getRequest());
        $this->assertSame($identifier, $instance->getIdentifier());
        $this->assertSame(null, $instance->getUser());
    }
}
