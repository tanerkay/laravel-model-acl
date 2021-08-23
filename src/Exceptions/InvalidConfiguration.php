<?php

namespace Tanerkay\ModelAcl\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Tanerkay\ModelAcl\Contracts\AccessControlContract;

class InvalidConfiguration extends Exception
{
    public static function modelIsNotValid(string $className): self
    {
        return new static("The given model class `{$className}` does not implement `".AccessControlContract::class.'` or it does not extend `'.Model::class.'`');
    }
}
