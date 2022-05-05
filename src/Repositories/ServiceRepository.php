<?php

namespace ConsulConfigManager\Consul\Agent\Repositories;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Agent\Models\Service;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceInterface;
use ConsulConfigManager\Consul\Agent\AggregateRoots\ServiceAggregateRoot;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceRepositoryInterface;

/**
 * Class ServiceRepository
 * @package ConsulConfigManager\Consul\Agent\Repositories
 */
class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function all(array $columns = ['*']): Collection
    {
        return Service::all($columns);
    }

    /**
     * @inheritDoc
     */
    public function find(string $identifier, array $columns = ['*']): ServiceInterface|Model|null
    {
        return $this->findBy(
            field: 'identifier',
            value: $identifier,
            columns: $columns
        );
    }

    /**
     * @inheritDoc
     */
    public function findOrFail(string $identifier, array $columns = ['*']): ServiceInterface
    {
        return $this->findByOrFail(
            field: 'identifier',
            value: $identifier,
            columns: $columns
        );
    }

    /**
     * @inheritDoc
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ServiceInterface|null
    {
        return Service::where($field, '=', $value)->first($columns);
    }

    /**
     * @inheritDoc
     */
    public function findManyBy(string $field, mixed $value, array $columns = ['*']): Collection
    {
        return Service::where($field, '=', $value)->get($columns);
    }

    /**
     * @inheritDoc
     */
    public function findByOrFail(string $field, mixed $value, array $columns = ['*']): ServiceInterface
    {
        return Service::where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     * @inheritDoc
     */
    public function create(array $configuration): ServiceInterface
    {
        $uuid = Str::uuid()->toString();
        ServiceAggregateRoot::retrieve($uuid)
            ->createEntity($configuration)
            ->persist();
        return Service::uuid($uuid);
    }

    /**
     * @inheritDoc
     */
    public function update(array $configuration): ServiceInterface
    {
        $model = $this->findOrFail(Arr::get($configuration, 'id'), ['uuid']);
        ServiceAggregateRoot::retrieve($model->getUuid())
            ->updateEntity($configuration)
            ->persist();
        return Service::uuid($model->getUuid());
    }

    /**
     * @inheritDoc
     */
    public function delete(string $identifier, bool $forceDelete = false): bool
    {
        try {
            $model = $this->findOrFail($identifier, ['uuid']);
            ServiceAggregateRoot::retrieve($model->getUuid())
                ->deleteEntity()
                ->persist();
            return true;
        } catch (Throwable) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function forceDelete(string $identifier): bool
    {
        return $this->delete($identifier, true);
    }
}
