<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Events;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use ConsulConfigManager\Consul\Agent\Test\TestCase;
use ConsulConfigManager\Consul\Agent\Events\AbstractEvent;

/**
 * Class AbstractEventTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Events
 */
abstract class AbstractEventTest extends TestCase
{
    /**
     * Currently active event handler
     * @var string
     */
    protected string $activeEventHandler;

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromGetDateTimeMethod(array $data): void
    {
        $this->assertNotEquals(0, $this->createClassInstance($data)->getDateTime());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromSetDateTimeMethod(array $data): void
    {
        if (!Arr::exists($data, 'time')) {
            $this->markTestSkipped('There is no `time` present on the data array');
        }

        $instance = $this->createClassInstance($data);

        /**
         * @var Carbon $carbonInstance
         */
        $carbonInstance = Arr::get($data, 'time');
        $instance->setDateTime($carbonInstance);

        $this->assertEquals($carbonInstance->getTimestamp(), $instance->getDateTime());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromGetUserMethod(array $data): void
    {
        $this->assertEquals(1, $this->createClassInstance($data)->getUser());
    }

    /**
     * @param array $data
     *
     * @return void
     * @dataProvider eventDataProvider
     * @throws Exception
     */
    public function testShouldPassIfValidDataReturnedFromSetUserMethod(array $data): void
    {
        if (!Arr::exists($data, 'user')) {
            $this->markTestSkipped('There is no `user` present on the data array');
        }
        $instance = $this->createClassInstance($data);
        $instance->setUser(Arr::get($data, 'user'));
        $this->assertEquals(1, $instance->getUser());
    }

    /**
     * Create new instance of event handler class
     * @param array $data
     * @return AbstractEvent
     */
    abstract protected function createClassInstance(array $data): AbstractEvent;
}
