<?php

namespace Tanerkay\ModelAcl\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Tanerkay\ModelAcl\Contracts\AccessControlContract as ActivityContract;

class ModelHasAccessControl extends Model implements ActivityContract
{
    public $guarded = [];

    protected $table = 'model_has_access_control';

    protected $casts = [
        'properties' => 'collection',
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($this->connection)) {
            $this->setConnection(config('model_acl.database_connection'));
        }

        if (! isset($this->table)) {
            $this->setTable(config('model_acl.table_name'));
        }

        parent::__construct($attributes);
    }

    public function subject(): MorphTo
    {
        if (config('model_acl.subject_returns_soft_deleted_models')) {
            return $this->morphTo()->withTrashed();
        }

        return $this->morphTo();
    }

    public function access(): Collection
    {
        if (! $this->properties instanceof Collection) {
            return new Collection();
        }

        return $this->properties->only(['attributes', 'old']);
    }

    public function getAccessAttribute(): Collection
    {
        return $this->access();
    }

    public function scopeForSubject(Builder $query, Model $subject): Builder
    {
        return $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }
}
