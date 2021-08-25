# Model-based access control

`tanerkay/laravel-model-access` allows record-level access control based on custom authorization rules.

Here's a demo of how you can use it:

```php
use Illuminate\Database\Eloquent\Model;
use Tanerkay\ModelAcl\Traits\ModelBasedAccessControl;

class Report extends Model
{
    use ModelBasedAccessControl;
    
    // ...
}

$report->can('view');
```

## Support the developer

To be added...

## Documentation

To be added...

## Installation

``` bash
composer require tanerkay/laravel-model-acl
```

You can publish the migration with:
```bash
php artisan vendor:publish --provider="Tanerkay\ModelAcl\ModelAclServiceProvider" --tag="model-acl-migrations"
```

```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="Tanerkay\ModelAcl\ModelAclServiceProvider" --tag="model-acl-config"
```

## Testing

``` bash
composer test
```

## Thanks

- [Spatie](https://spatie.be) for making awesome packages, this package leverages `spatie/laravel-package-tools` and is itself derived from `spatie/laravel-activitylog`.

## License

[The MIT License (MIT)](https://mit-license.org/)
