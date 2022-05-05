<?php

namespace ConsulConfigManager\Consul\Agent\Projectors\Service;

use Illuminate\Support\Arr;
use ConsulConfigManager\Consul\Agent\Events\Service;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use ConsulConfigManager\Consul\Agent\Models\Service as ServiceModel;

/**
 * Class ServiceProjector
 * @package ConsulConfigManager\Consul\Agent\Projectors\Service
 */
class ServiceProjector extends Projector
{
    /**
     * Handle `created` event
     * @param Service\ServiceCreated $event
     * @return void
     */
    public function onCreated(Service\ServiceCreated $event): void
    {
        ServiceModel::create($this->processServiceConfiguration(
            $event->aggregateRootUuid(),
            $event->getConfiguration()
        ));
    }

    /**
     * Handle `updated` event
     * @param Service\ServiceUpdated $event
     * @return void
     */
    public function onUpdated(Service\ServiceUpdated $event): void
    {
        $uuid = $event->aggregateRootUuid();
        $configuration = $this->processServiceConfiguration(
            $uuid,
            $event->getConfiguration()
        );
        $model = ServiceModel::uuid($uuid);

        if (isset($configuration['identifier'])) {
            $model->setIdentifier(Arr::get(
                $configuration,
                'identifier'
            ));
        }

        if (isset($configuration['service'])) {
            $model->setService(Arr::get(
                $configuration,
                'service'
            ));
        }

        if (isset($configuration['address'])) {
            $model->setAddress(Arr::get(
                $configuration,
                'address'
            ));
        }

        if (isset($configuration['port'])) {
            $model->setPort(Arr::get(
                $configuration,
                'port'
            ));
        }

        if (isset($configuration['datacenter'])) {
            $model->setDatacenter(Arr::get(
                $configuration,
                'datacenter'
            ));
        }

        if (isset($configuration['tags'])) {
            $model->setTags(Arr::get(
                $configuration,
                'tags'
            ));
        }

        if (isset($configuration['meta'])) {
            $model->setMeta(Arr::get(
                $configuration,
                'meta'
            ));
        }

        if (isset($configuration['online'])) {
            $model->setOnline(Arr::get(
                $configuration,
                'online'
            ));
        }

        if (isset($configuration['environment'])) {
            $model->setEnvironment(Arr::get(
                $configuration,
                'environment',
                'development'
            ));
        }

        $model->save();
    }

    /**
     * Handle `deleted` event
     * @param Service\ServiceDeleted $event
     * @return void
     */
    public function onDeleted(Service\ServiceDeleted $event): void
    {
        ServiceModel::uuid($event->aggregateRootUuid())->delete();
    }

    /**
     * Process service configuration
     * @param string $uuid
     * @param array $configuration
     * @return array
     */
    private function processServiceConfiguration(string $uuid, array $configuration): array
    {
        $finalArray = Arr::except($configuration, [
            'id',
            'socket_path',
            'tagged_addresses',
            'weights',
            'enable_tag_override',
        ]);
        if (isset($configuration['id'])) {
            $finalArray['identifier'] = Arr::get($configuration, 'id');
        }
        Arr::set($finalArray, 'uuid', $uuid);
        if (isset($configuration['meta']) && isset($configuration['meta']['environment'])) {
            $finalArray['environment'] = Arr::get($configuration, 'meta.environment', 'development');
        }
        return $finalArray;
    }
}
