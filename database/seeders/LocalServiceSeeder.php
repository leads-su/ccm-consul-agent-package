<?php

namespace ConsulConfigManager\Consul\Agent\Database\Seeders;

use Illuminate\Database\Seeder;
use ConsulConfigManager\Consul\Agent\Models\Service;

/**
 * Class LocalServiceSeeder
 * @package ConsulConfigManager\Consul\Agent\Database\Seeders
 */
class LocalServiceSeeder extends Seeder
{
    /**
     * Local Server Uuid
     * @var string
     */
    private string $uuid = '00000000-0000-0000-0000-000000000000';

    /**
     * Local Server Identifier
     * @var string
     */
    private string $identifier = 'ccm_ui-localhost-127.0.0.1';

    /**
     * Local Server Service Name
     * @var string
     */
    private string $service = 'ccm_ui';

    /**
     * Local Server Address
     * @var string
     */
    private string $address = '127.0.0.1';

    /**
     * Local Server Port
     * @var int
     */
    private int $port = 0;

    /**
     * Local Server Datacenter
     * @var string
     */
    private string $datacenter = 'local';

    /**
     * Local Server Tags List
     * @var array
     */
    private array $tags = [];

    /**
     * Local Server Meta List
     * @var array
     */
    private array $meta = [];

    /**
     * Local Server Online Status
     * @var bool
     */
    private bool $online = true;

    /**
     * Local Server Environment Name
     * @var string
     */
    private string $environment = 'local';

    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        $model = Service::where('uuid', '=', $this->uuid)->first();
        if ($model === null) {
            $instance = new Service();
            $instance->setUuid($this->uuid);
            $instance->setIdentifier($this->identifier);
            $instance->setService($this->service);
            $instance->setAddress($this->address);
            $instance->setPort($this->port);
            $instance->setDatacenter($this->datacenter);
            $instance->setTags($this->tags);
            $instance->setMeta($this->meta);
            $instance->setOnline($this->online);
            $instance->setEnvironment($this->environment);
            $instance->save();
        }
    }
}
