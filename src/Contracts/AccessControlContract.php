<?php

namespace Tanerkay\ModelAcl\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

interface AccessControlContract
{
    public function subject(): MorphTo;

    public function access(): Collection;

    public function scopeForSubject(Builder $query, Model $subject): Builder;
}
