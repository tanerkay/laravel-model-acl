<?php

namespace Tanerkay\ModelAcl\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Tanerkay\ModelAcl\Contracts\RuleContract;

class HasRole implements RuleContract
{
    public function authorize(?Authenticatable $user, ...$arguments): bool
    {
        $user ??= Auth::user();

        $user->hasRole($arguments);
    }
}
