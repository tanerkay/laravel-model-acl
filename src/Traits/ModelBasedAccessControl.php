<?php

namespace Tanerkay\ModelAcl\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tanerkay\ModelAcl\ModelAclServiceProvider;
use Tanerkay\ModelAcl\AccessControlStatus;

trait ModelBasedAccessControl
{
    protected bool $disableModelBasedAccessControl = false;

    public function accessControl(): MorphMany
    {
        return $this->morphMany(ModelAclServiceProvider::determineAccessControlModel(), 'subject');
    }

    protected function shouldUseModelBasedAccessControl(): bool
    {
        $accessControlStatus = app(AccessControlStatus::class);

        if ($this->disableModelBasedAccessControl || $accessControlStatus->disabled()) {
            return false;
        }

        return true;
    }
}
