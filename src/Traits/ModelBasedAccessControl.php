<?php

namespace Tanerkay\ModelAcl\Traits;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Tanerkay\ModelAcl\ModelAclServiceProvider;
use Tanerkay\ModelAcl\AccessControlStatus;
use Tanerkay\ModelAcl\Models\ModelHasAccessControl;

/**
 * @property-read Collection<ModelHasAccessControl> $accessControl
 */
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

    public function can($ability, ?Authenticatable $user = null): bool
    {
        return $this->accessControl->each(function ($accessControl) {
            // ...
        })->every(true);
    }

    public function cannot($ability, ?Authenticatable $user = null): bool
    {
        return ! $this->can($ability, $user);
    }
}
