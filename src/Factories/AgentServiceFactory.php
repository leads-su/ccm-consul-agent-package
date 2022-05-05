<?php

namespace ConsulConfigManager\Consul\Agent\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use ConsulConfigManager\Consul\Agent\Models\Service;

/**
 * Class AgentServiceFactory
 * @package ConsulConfigManager\Consul\Agent\Factories
 */
class AgentServiceFactory extends Factory
{
    /**
     * @inheritDoc
     */
    protected $model = Service::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        $ipv4 = $this->faker->ipv4;
        return [
            'id'                        =>  $this->faker->unique()->numberBetween(1, 10),
            'uuid'                      =>  $this->faker->uuid(),
            'identifier'                =>  'ccm-example-' . $ipv4,
            'service'                   =>  'ccm',
            'address'                   =>  $ipv4,
            'port'                      =>  32175,
            'datacenter'                =>  'dc0',
            'tags'                      =>  [],
            'meta'                      =>  [
                'operating_system'      =>  'linux',
                'log_level'             =>  'DEBUG',
                'go_version'            =>  '1.17.2',
                'environment'           =>  'development',
                'architecture'          =>  'amd64',
                'application_version'   =>  $this->faker->semver(),
            ],
            'online'                    =>  true,
            'environment'               =>  'development',
            'created_at'                =>  Carbon::now(),
            'updated_at'                =>  Carbon::now(),
            'deleted_at'                =>  null,
        ];
    }
}
