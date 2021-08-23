<?php

namespace Tanerkay\ModelAcl\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface RuleContract
{
    public function authorize(?Authenticatable $user, ...$arguments): void;
}
