<?php

namespace ConsulConfigManager\Consul\Agent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ConsulConfigManager\Consul\Agent\Interfaces\ServiceInterface;
use ConsulConfigManager\Consul\Agent\Factories\AgentServiceFactory;

/**
 * Class Service
 * @package ConsulConfigManager\Consul\Agent\Models
 */
class Service extends Model implements ServiceInterface
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @inheritDoc
     */
    public $table = 'consul_services';

    /**
     * @inheritDoc
     */
    protected $fillable = [
        'id',
        'uuid',
        'identifier',
        'service',
        'address',
        'port',
        'datacenter',
        'tags',
        'meta',
        'online',
        'environment',
    ];

    /**
     * @inheritDoc
     */
    protected $casts = [
        'id'            =>  'integer',
        'uuid'          =>  'string',
        'identifier'    =>  'string',
        'service'       =>  'string',
        'address'       =>  'string',
        'port'          =>  'integer',
        'datacenter'    =>  'string',
        'tags'          =>  'array',
        'meta'          =>  'array',
        'online'        =>  'boolean',
        'environment'   =>  'string',
    ];

    /**
     * @inheritDoc
     */
    protected $guarded = [];

    /**
     * @inheritDoc
     */
    protected $hidden = [];

    /**
     * @inheritDoc
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @inheritDoc
     */
    protected $with = [

    ];

    /**
     * @inheritDoc
     */
    public static function uuid(string $uuid, bool $withTrashed = false): ?ServiceInterface
    {
        $query = static::where('uuid', '=', $uuid);
        if ($withTrashed) {
            return $query->withTrashed()->first();
        }
        return $query->first();
    }

    /**
     * @inheritDoc
     */
    protected static function newFactory(): Factory
    {
        return AgentServiceFactory::new();
    }

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->attributes['id'];
    }

    /**
     * @inheritDoc
     */
    public function setID(int $id): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUuid(): string
    {
        return (string) $this->attributes['uuid'];
    }

    /**
     * @inheritDoc
     */
    public function setUuid(string $uuid): self
    {
        $this->attributes['uuid'] = $uuid;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIdentifier(): string
    {
        return (string) $this->attributes['identifier'];
    }

    /**
     * @inheritDoc
     */
    public function setIdentifier(string $identifier): ServiceInterface
    {
        $this->attributes['identifier'] = $identifier;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getService(): string
    {
        return (string) $this->attributes['service'];
    }

    /**
     * @inheritDoc
     */
    public function setService(string $service): ServiceInterface
    {
        $this->attributes['service'] = $service;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAddress(): string
    {
        return (string) $this->attributes['address'];
    }

    /**
     * @inheritDoc
     */
    public function setAddress(string $address): ServiceInterface
    {
        $this->attributes['address'] = $address;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPort(): int
    {
        return (int) $this->attributes['port'];
    }

    /**
     * @inheritDoc
     */
    public function setPort(int $port): ServiceInterface
    {
        $this->attributes['port'] = $port;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDatacenter(): string
    {
        return (string) $this->attributes['datacenter'];
    }

    /**
     * @inheritDoc
     */
    public function setDatacenter(string $datacenter): ServiceInterface
    {
        $this->attributes['datacenter'] = $datacenter;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTags(): array
    {
        return (array) json_decode($this->attributes['tags'], true);
    }

    /**
     * @inheritDoc
     */
    public function setTags(array $tags): ServiceInterface
    {
        $this->attributes['tags'] = json_encode($tags);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMeta(): array
    {
        return (array) json_decode($this->attributes['meta'], true);
    }

    /**
     * @inheritDoc
     */
    public function setMeta(array $meta): ServiceInterface
    {
        $this->attributes['meta'] = json_encode($meta);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isOnline(): bool
    {
        return (bool) $this->attributes['online'];
    }

    /**
     * @inheritDoc
     */
    public function setOnline(bool $online): ServiceInterface
    {
        $this->attributes['online'] = $online;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEnvironment(): string
    {
        return (string) $this->attributes['environment'];
    }

    /**
     * @inheritDoc
     */
    public function setEnvironment(string $environment): ServiceInterface
    {
        $this->attributes['environment'] = $environment;
        return $this;
    }
}
