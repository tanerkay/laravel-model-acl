<?php

namespace Tanerkay\ModelAcl;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tanerkay\ModelAcl\Contracts\AccessControlContract;
use Tanerkay\ModelAcl\Exceptions\InvalidConfiguration;
use Tanerkay\ModelAcl\Models\ModelHasAccessControl;

class ModelAclServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-model-acl')
            ->hasConfigFile('model_acl')
            ->hasMigrations([
                'create_model_has_access_control_table',
            ]);
    }

    public function registeringPackage()
    {
        $this->app->singleton(AccessControlStatus::class);
    }

    public static function determineAccessControlModel(): string
    {
        $model = config('model_acl.access_control_model') ?? ModelHasAccessControl::class;

        if (! is_a($model, AccessControlContract::class, true)
            || ! is_a($model, Model::class, true)) {
            throw InvalidConfiguration::modelIsNotValid($model);
        }

        return $model;
    }

    public static function getAccessControlModelInstance(): AccessControlContract
    {
        $accessControlModelClassName = self::determineAccessControlModel();

        return new $accessControlModelClassName();
    }
}
