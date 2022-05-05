<?php

namespace ConsulConfigManager\Consul\Agent\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface ServiceRepositoryInterface
 * @package ConsulConfigManager\Consul\Agent\Interfaces
 */
interface ServiceRepositoryInterface
{
    /**
     * Get list of all service entries from database
     * @param array|string[] $columns
     *
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Find entity by path
     * @param string         $identifier
     * @param array|string[] $columns
     *
     * @return ServiceInterface|Model|null
     */
    public function find(string $identifier, array $columns = ['*']): ServiceInterface|Model|null;

    /**
     * Find entity by path or fail
     * @param string         $identifier
     * @param array|string[] $columns
     *
     * @throws ModelNotFoundException
     * @return ServiceInterface
     */
    public function findOrFail(string $identifier, array $columns = ['*']): ServiceInterface;

    /**
     * Find entity by specified field and value
     * @param string $field
     * @param mixed $value
     * @param array|string[] $columns
     * @return ServiceInterface|null
     */
    public function findBy(string $field, mixed $value, array $columns = ['*']): ServiceInterface|null;

    /**
     * Find many entities by specified field and value
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return Collection
     */
    public function findManyBy(string $field, mixed $value, array $columns = ['*']): Collection;

    /**
     * Find entity by specified field and value and fail if not found
     * @param string $field
     * @param mixed $value
     * @param array|string[] $columns
     * @throws ModelNotFoundException
     * @return ServiceInterface
     */
    public function findByOrFail(string $field, mixed $value, array $columns = ['*']): ServiceInterface;

    /**
     * Create new entity
     * @param array $configuration
     *
     * @return ServiceInterface
     */
    public function create(array $configuration): ServiceInterface;

    /**
     * Update existing entity
     * @param array $configuration
     *
     * @return ServiceInterface
     */
    public function update(array $configuration): ServiceInterface;

    /**
     * Delete existing entity
     * @param string $identifier
     * @param bool   $forceDelete
     *
     * @return bool
     */
    public function delete(string $identifier, bool $forceDelete = false): bool;

    /**
     * Force delete existing entity
     * @param string $identifier
     *
     * @return bool
     */
    public function forceDelete(string $identifier): bool;
}
