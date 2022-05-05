<?php

namespace ConsulConfigManager\Consul\Agent\Providers;

use Illuminate\Support\Facades\Route;
use ConsulConfigManager\Consul\Agent\UseCases;
use Spatie\EventSourcing\Facades\Projectionist;
use ConsulConfigManager\Consul\Agent\Interfaces;
use ConsulConfigManager\Consul\Agent\Presenters;
use ConsulConfigManager\Consul\Agent\Projectors;
use ConsulConfigManager\Consul\Agent\Repositories;
use ConsulConfigManager\Domain\DomainServiceProvider;
use ConsulConfigManager\Consul\Agent\Http\Controllers;
use ConsulConfigManager\Consul\Agent\ConsulAgentDomain;
use ConsulConfigManager\Consul\Agent\Services\AgentService;
use ConsulConfigManager\Consul\Agent\Interfaces\AgentServiceInterface;
use ConsulConfigManager\Consul\Agent\Commands\ConsulServiceSynchronizeCommand;

/**
 * Class ConsulAgentServiceProvider
 * @package ConsulConfigManager\Consul\Agent\Providers
 */
class ConsulAgentServiceProvider extends DomainServiceProvider
{
    /**
     * List of commands provided by package
     * @var array
     */
    protected array $packageCommands = [
        ConsulServiceSynchronizeCommand::class,
    ];

    /**
     * List of repositories provided by package
     * @var array
     */
    protected array $packageRepositories = [
        Interfaces\ServiceRepositoryInterface::class        =>  Repositories\ServiceRepository::class,
    ];

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        $this->registerConfiguration();
        parent::register();
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->registerRoutes();
        $this->offerPublishing();
        $this->registerMigrations();
        $this->registerCommands();
        parent::boot();
    }


    /**
     * Register package configuration
     * @return void
     */
    protected function registerConfiguration(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'consul.agent'
        );
    }

    /**
     * Register package migrations
     * @return void
     */
    protected function registerMigrations(): void
    {
        if (ConsulAgentDomain::shouldRunMigrations()) {
            $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        }
    }

    /**
     * Register package routes
     * @return void
     */
    protected function registerRoutes(): void
    {
        if (ConsulAgentDomain::shouldRegisterRoutes()) {
            Route::prefix(config('consul.agent.prefix'))
                ->middleware(config('consul.agent.middleware'))
                ->group(function (): void {
                    $this->loadRoutesFrom(__DIR__ . '/../../routes/routes.php');
                });
        }
    }

    /**
     * Register package commands
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->packageCommands);
        }
    }

    /**
     * Offer resources for publishing
     * @return void
     */
    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/config.php'        =>  config_path('consul/agent.php'),
            ], ['ccm-consul-agent-configuration', 'ccm-consul-agent']);
            $this->publishes([
                __DIR__ . '/../../database/migrations'      =>  database_path('migrations'),
            ], ['ccm-consul-agent-migrations', 'ccm-consul-agent']);
        }
    }

    /**
     * @inheritDoc
     */
    protected function registerFactories(): void
    {
    }

    /**
     * @inheritDoc
     */
    protected function registerRepositories(): void
    {
        foreach ($this->packageRepositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /**
     * @inheritDoc
     */
    protected function registerInterceptors(): void
    {
        $this->registerInterceptorFromParameters(
            UseCases\Service\List\ServiceListInputPort::class,
            UseCases\Service\List\ServiceListInteractor::class,
            Controllers\ServiceListController::class,
            Presenters\Service\ServiceListHttpPresenter::class,
        );

        $this->registerInterceptorFromParameters(
            UseCases\Service\Get\ServiceGetInputPort::class,
            UseCases\Service\Get\ServiceGetInteractor::class,
            Controllers\ServiceGetController::class,
            Presenters\Service\ServiceGetHttpPresenter::class,
        );
    }

    /**
     * @inheritDoc
     */
    protected function registerServices(): void
    {
        $this->app->bind(AgentServiceInterface::class, AgentService::class);
    }

    /**
     * @inheritDoc
     */
    protected function registerReactors(): void
    {
    }

    /**
     * @inheritDoc
     */
    protected function registerProjectors(): void
    {
        Projectionist::addProjectors([
            Projectors\Service\ServiceProjector::class,
        ]);
    }
}
