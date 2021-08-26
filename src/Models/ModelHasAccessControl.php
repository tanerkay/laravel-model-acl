<?php

namespace Tanerkay\ModelAcl\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;
use Tanerkay\ModelAcl\Contracts\AccessControlContract;
use Tanerkay\ModelAcl\Contracts\RuleContract;

/**
 * Model has access control
 *
 * @property int $id
 * @property string $subject_type
 * @property int $subject_id
 * @property string $description
 * @property Collection $abilities
 * @property Collection $rules
 * @property-read Model $subject
 */
class ModelHasAccessControl extends Model implements AccessControlContract
{
    public $guarded = [];

    protected $casts = [
        'abilities' => 'collection',
        'rules' => 'collection',
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

    public function scopeForSubject(Builder $query, Model $subject): Builder
    {
        return $query
            ->where('subject_type', $subject->getMorphClass())
            ->where('subject_id', $subject->getKey());
    }

    public function authorize(string $ability, ?Authenticatable $user = null): void
    {
        if (! $this->hasAbility($ability)) {
            return;
        }

        $this->rules->each(function (object|array $ruleDefinition) use ($user) {
            $ruleClass = data_get($ruleDefinition, 'class');

            /** @var RuleContract $rule */
            $rule = new $ruleClass();
            $rule->authorize($user, data_get($ruleDefinition, 'arguments'));
        });
    }

    public function hasAbility(string $ability): bool
    {
        return $this->abilities->contains('*') || $this->abilities->contains($ability);
    }
}
