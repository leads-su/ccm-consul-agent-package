<?php

namespace ConsulConfigManager\Consul\Agent\Test;

use Illuminate\Foundation\Application;
use ConsulConfigManager\Testing\Concerns;
use ConsulConfigManager\Users\Models\User;
use Spatie\EventSourcing\EventSourcingServiceProvider;
use ConsulConfigManager\Consul\Agent\ConsulAgentDomain;
use ConsulConfigManager\Users\ValueObjects\EmailValueObject;
use ConsulConfigManager\Users\Providers\UsersServiceProvider;
use ConsulConfigManager\Users\ValueObjects\UsernameValueObject;
use ConsulConfigManager\Users\ValueObjects\PasswordValueObject;
use ConsulConfigManager\Consul\Agent\Providers\ConsulAgentServiceProvider;

/**
 * Class TestCase
 * @package ConsulConfigManager\Consul\Agent\Test
 */
abstract class TestCase extends \ConsulConfigManager\Testing\TestCase
{
    use Concerns\WithQueueMigrations;
    use Concerns\WithEventSourcingMigrations;

    /**
     * @inheritDoc
     */
    protected array $packageProviders = [
        EventSourcingServiceProvider::class,
        ConsulAgentServiceProvider::class,
        UsersServiceProvider::class,
    ];

    /**
     * @inheritDoc
     */
    protected bool $configurationFromEnvironment = true;

    /**
     * @inheritDoc
     */
    protected string $configurationFromFile = __DIR__ . '/..';

    /**
     * @inheritDoc
     */
    public function runBeforeSetUp(): void
    {
        ConsulAgentDomain::registerRoutes();
    }

    /**
     * @inheritDoc
     */
    public function runAfterSetUp(): void
    {
        User::create([
            'first_name'    =>  'System',
            'last_name'     =>  'User',
            'username'      =>  new UsernameValueObject('system'),
            'email'         =>  new EmailValueObject('admin@leads.su'),
            'password'      =>  new PasswordValueObject('1234567890'),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function runBeforeTearDown(): void
    {
        ConsulAgentDomain::ignoreRoutes();
    }

    /**
     * @inheritDoc
     */
    public function setUpEnvironment(Application $app): void
    {
        $this->setconfigurationValue('consul.agent', [
            'default'           =>  env('CONSUL_SERVER_CONNECTION', 'default'),
            'auto_select'       =>  env('CONSUL_SERVER_AUTO_SELECT', false),
            'use_random'        =>  env('CONSUL_SERVER_USE_RANDOM', false),
            'datacenter'        =>  env('CONSUL_SERVER_DATACENTER', 'dc0'),
            'access_token'      =>  env('CONSUL_SERVER_TOKEN', ''),
            'connections'       =>  [
                'default'       =>  [
                    'scheme'        =>  env('CONSUL_SERVER_SCHEME', 'http'),
                    'host'          =>  env('CONSUL_SERVER_HOST', '127.0.0.1'),
                    'port'          =>  env('CONSUL_SERVER_PORT', 8500),
                ],
            ],
            'system_user'           =>  [
                'email'             =>  env('CONSUL_SYSTEM_USER_EMAIL', 'admin@leads.su'),
                'password'          =>  env('CONSUL_SYSTEM_USER_PASSWORD', '1234567890'),
            ],
            'prefix'                =>  'consul',
            'middleware'            =>  [
                'api',
            ],
        ], $app);

        $this->setConfigurationValue('permission', [
            'models' => [
                'permission' => \Spatie\Permission\Models\Permission::class,
                'role' => \Spatie\Permission\Models\Role::class,
            ],
            'table_names' => [
                'roles' => 'roles',
                'permissions' => 'permissions',
                'model_has_permissions' => 'model_has_permissions',
                'model_has_roles' => 'model_has_roles',
                'role_has_permissions' => 'role_has_permissions',
            ],
            'column_names' => [
                'role_pivot_key' => 'role_id',
                'permission_pivot_key' => 'permission_id',
                'model_morph_key' => 'model_id',
                'team_foreign_key' => 'team_id',
            ],
            'teams' => false,
            'display_permission_in_exception' => false,
            'display_role_in_exception' => false,
            'enable_wildcard_permission' => false,
            'cache' => [
                'expiration_time' => \DateInterval::createFromDateString('24 hours'),
                'key' => 'spatie.permission.cache',
                'store' => 'default',
            ],
        ], $app);

        $this->setConfigurationValue(
            'event-sourcing.snapshot_repository',
            \Spatie\EventSourcing\Snapshots\EloquentSnapshotRepository::class,
            $app
        );

        $this->setConfigurationValue(
            'event-sourcing.stored_event_repository',
            \Spatie\EventSourcing\StoredEvents\Repositories\EloquentStoredEventRepository::class,
            $app
        );
    }
}
