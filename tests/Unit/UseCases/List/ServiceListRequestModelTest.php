<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\UseCases\List;

use ConsulConfigManager\Consul\Agent\Test\TestCase;
use ConsulConfigManager\Consul\Agent\UseCases\Service\List\ServiceListRequestModel;

/**
 * Class ServiceListRequestModelTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\UseCases\List
 */
class ServiceListRequestModelTest extends TestCase
{
    public function testShouldPassIfInstanceOfRequestIsReturned(): void
    {
        $request = request();
        $instance = new ServiceListRequestModel($request);
        $this->assertSame($request, $instance->getRequest());
        $this->assertSame(null, $instance->getUser());
    }
}
