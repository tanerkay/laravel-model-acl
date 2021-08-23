<?php

namespace Tanerkay\ModelAcl\Exceptions;

use Exception;
use Illuminate\Support\Str;

class AuthorizationException extends Exception
{
    public static function noUserModel(): self
    {
        return new static('No user returned from auth provider. Check if the correct auth guard is set in `laravel_model_acl.default_auth_driver`.');
    }

    public static function invalidUserModel(): self
    {
        return new static('Invalid user returned from auth provider, user model must implement `Illuminate\Contracts\Auth\Authenticatable`.');
    }

    public static function doesNotHaveRole($roles): self
    {
        return new static(sprintf(
            'The user does not have the required %s <%s> to access this model.',
            Str::plural('role', count($roles)),
            join(', ', $roles)
        ));
    }

    public static function doesNotHavePermission($permissions): self
    {
        return new static(sprintf(
            'The user does not have the required %s <%s> to access this model.',
            Str::plural('permission', count($permissions)),
            join(', ', $permissions)
        ));
    }
}
