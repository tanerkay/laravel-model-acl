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

    public function can($ability, ?Authenticatable $user = null): void
    {
        if (! $this->shouldUseModelBasedAccessControl()) {
            return;
        }

        $this->accessControl->each(
            fn (ModelHasAccessControl $accessControl) => $accessControl->authorize($ability, $user)
        );
    }

    public function addAccessControl(string|array $abilities, object|array $ruleDefinitions, ?string $description = null)
    {
        $accessControl = new ModelHasAccessControl();
        $accessControl->abilities = (array) $abilities;
        $accessControl->description = $description;
        $accessControl->rules = $ruleDefinitions;

        $this->accessControl()->save($accessControl);
    }
}
