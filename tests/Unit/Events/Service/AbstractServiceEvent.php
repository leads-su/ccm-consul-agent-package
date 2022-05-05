<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service;

use Illuminate\Support\Carbon;
use ConsulConfigManager\Users\Models\User;
use ConsulConfigManager\Users\ValueObjects\EmailValueObject;
use ConsulConfigManager\Users\ValueObjects\UsernameValueObject;
use ConsulConfigManager\Consul\Agent\Test\Unit\Events\AbstractEventTest;

/**
 * Class AbstractServiceEvent
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Events\Service
 */
abstract class AbstractServiceEvent extends AbstractEventTest
{
    /**
     * Event data provider configuration
     * @return \array[][]
     */
    public function eventDataProvider(): array
    {
        return [
            'ccm-example-127.0.0.1'             =>  [
                'data'                          =>  [
                    'id'                        =>  'ccm-example-127.0.0.1',
                    'uuid'                      =>  'aa52111e-751a-4ca2-a63e-01acdce449c5',
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
                    'time'                      =>  Carbon::now(),
                    'user'                      =>  new User([
                        'id'                    =>  1,
                        'first_name'            =>  'John',
                        'last_name'             =>  'Doe',
                        'username'              =>  new UsernameValueObject('john.doe'),
                        'email'                 =>  new EmailValueObject('john.doe@example.com'),
                    ]),

                ],
            ],
        ];
    }
}
