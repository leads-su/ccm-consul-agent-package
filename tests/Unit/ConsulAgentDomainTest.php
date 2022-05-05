<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit;

use ConsulConfigManager\Consul\Agent\Test\TestCase;
use ConsulConfigManager\Consul\Agent\ConsulAgentDomain;

/**
 * Class ConsulAgentDomainTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit
 */
class ConsulAgentDomainTest extends TestCase
{
    /**
     * @return void
     */
    public function testMigrationsShouldRunByDefault(): void
    {
        $this->assertTrue(ConsulAgentDomain::shouldRunMigrations());
    }

    /**
     * @return void
     */
    public function testMigrationsPublishingCanBeDisabled(): void
    {
        ConsulAgentDomain::ignoreMigrations();
        $this->assertFalse(ConsulAgentDomain::shouldRunMigrations());
        ConsulAgentDomain::registerMigrations();
    }

    /**
     * @return void
     */
    public function testRoutesShouldNotBeRegisteredByDefault(): void
    {
        ConsulAgentDomain::ignoreRoutes();
        $this->assertFalse(ConsulAgentDomain::shouldRegisterRoutes());
        ConsulAgentDomain::registerRoutes();
    }

    /**
     * @return void
     */
    public function testRoutesRegistrationCanBeEnabled(): void
    {
        ConsulAgentDomain::registerRoutes();
        $this->assertTrue(ConsulAgentDomain::shouldRegisterRoutes());
        ConsulAgentDomain::ignoreRoutes();
    }
}
