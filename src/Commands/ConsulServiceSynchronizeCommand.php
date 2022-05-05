<?php

namespace ConsulConfigManager\Consul\Agent\Commands;

use Illuminate\Support\Arr;
use Illuminate\Console\Command;
use Consul\Exceptions\RequestException;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceInterface;
use ConsulConfigManager\Consul\Agent\Interfaces\AgentServiceInterface;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceRepositoryInterface;

// @codeCoverageIgnoreStart

/**
 * Class ConsulServiceSynchronizeCommand
 * @package ConsulConfigManager\Consul\Agent\Commands
 */
class ConsulServiceSynchronizeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consul:agent:service:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize services list with Consul server';

    /**
     * Agent service instance
     * @var AgentServiceInterface
     */
    private AgentServiceInterface $client;

    /**
     * Service repository instance
     * @var ServiceRepositoryInterface
     */
    private ServiceRepositoryInterface $repository;

    /**
     * ConsulServiceSynchronizeCommand constructor.
     * @param AgentServiceInterface $client
     * @param ServiceRepositoryInterface $repository
     * @return void
     */
    public function __construct(
        AgentServiceInterface $client,
        ServiceRepositoryInterface $repository,
    ) {
        $this->client = $client;
        $this->repository = $repository;
        parent::__construct();
    }

    /**
     * Execute console command.
     * @return int
     * @throws RequestException
     */
    public function handle(): int
    {
        $localServices = $this->repository->all();
        $existingLocalServices = $localServices->map(function (ServiceInterface $service): string {
            return $service->getIdentifier();
        });

        $remoteServices = $this->client->listServices();
        $existingRemoteServices = collect(array_values(array_map(function (array $service): string {
            return Arr::get($service, 'id');
        }, $remoteServices)));

        $missingServices = array_diff($existingLocalServices->toArray(), $existingRemoteServices->toArray());

        foreach ($remoteServices as $identifier => $service) {
            $model = $this->repository->findBy('identifier', $identifier);
            $exists = $model !== null;

            if ($exists) {
                $this->repository->update(array_merge($service, [
                    'online'    =>  true,
                ]));
            } else {
                $this->repository->create(array_merge($service, [
                    'online'    =>  true,
                ]));
            }
        }

        foreach ($missingServices as $service) {
            $model = $this->repository->findBy('identifier', $service);
            $model->setOnline(false);
            $model->save();
        }

        return Command::SUCCESS;
    }
}

// @codeCoverageIgnoreEnd
