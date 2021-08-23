<?php

namespace Tanerkay\ModelAcl\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Tanerkay\ModelAcl\Exceptions\AuthorizationException;

class HasPermission extends Rule
{
    public function authorize(?Authenticatable $user, ...$arguments): void
    {
        $user ??= $this->getUser();

        $hasRole = config('model_acl.authenticatable_methods.has_permission');

        if (! $user->$hasRole($arguments)) {
            throw AuthorizationException::doesNotHavePermission($arguments);
        }
    }
}
