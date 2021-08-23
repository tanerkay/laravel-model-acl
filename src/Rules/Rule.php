<?php

namespace Tanerkay\ModelAcl\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Tanerkay\ModelAcl\Contracts\RuleContract;
use Tanerkay\ModelAcl\Exceptions\AuthorizationException;

abstract class Rule implements RuleContract
{
    protected function getUser(): Authenticatable
    {
        $user = Auth::guard(config('laravel_model_acl.default_auth_driver'))->user();

        if (! $user) {
            throw AuthorizationException::noUserModel();
        }

        if (! $user instanceof Authenticatable) {
            throw AuthorizationException::invalidUserModel();
        }

        return $user;
    }
}
