<?php

namespace Tanerkay\ModelAcl;

use Illuminate\Contracts\Config\Repository;

class AccessControlStatus
{
    protected bool $enabled = true;

    public function __construct(Repository $config)
    {
        $this->enabled = $config['model_acl.enabled'];
    }

    public function enable(): bool
    {
        return $this->enabled = true;
    }

    public function disable(): bool
    {
        return $this->enabled = false;
    }

    public function disabled(): bool
    {
        return $this->enabled === false;
    }
}
