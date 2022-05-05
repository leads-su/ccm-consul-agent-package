<?php

namespace ConsulConfigManager\Consul\Agent\Test\Unit\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use ConsulConfigManager\Consul\Agent\Test\TestCase;

/**
 * Class AbstractRepositoryTest
 * @package ConsulConfigManager\Consul\Agent\Test\Unit\Repositories
 */
abstract class AbstractRepositoryTest extends TestCase
{
    /**
     * Create array without dates from entity
     *
     * @param array|Model|Collection $entity
     * @param bool                     $nested
     *
     * @return array
     */
    protected function exceptDates(array|Model|Collection $entity, bool $nested = false): array
    {
        if (!is_array($entity)) {
            $entity = $entity->toArray();
        }

        if ($nested) {
            $data = [];
            foreach ($entity as $index => $value) {
                $data[$index] = Arr::except($value, [
                    'created_at',
                    'updated_at',
                    'deleted_at',
                ]);
            }
            return $data;
        }

        return Arr::except($entity, [
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }
}
