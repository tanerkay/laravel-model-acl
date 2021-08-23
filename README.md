# Model-based access control

`tanerkay/laravel-model-access` allows record-level

Here's a demo of how you can use it:

```php
use Tanerkay\ModelAcl\Traits\HasModelBasedAccessControl

class ReportPolicy
{
    use HasModelBasedAccessControl;
}


$user->can('view', $report);
```

## Support the developer



## Documentation



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

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## License

[The MIT License (MIT)](https://mit-license.org/)
