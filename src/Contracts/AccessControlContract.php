<?php

namespace Tanerkay\ModelAcl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

interface AccessControlContract
{
    public function subject(): MorphTo;

    public function scopeForSubject(Builder $query, Model $subject): Builder;

    public function authorize(string $ability, ?Authenticatable $user = null): void;
}
