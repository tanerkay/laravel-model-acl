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

$post->can('view');
```

## Support the developer

To be added...

## Documentation

### Assigning access control rules to individual models

The `addAccessControl()` method can be used to add rules to individual models.

```php
public function addAccessControl(
    string|array $abilities, 
    object|array $ruleDefinitions, 
    ?string $description = null
): void
```

It accepts:
- an ability name or list of abilities that can be used in calls to `can()`.
- an array of rule definitions, each rule definition is an array containing a class string `'class'` and an array of arguments `'arguments'`.
- an optional description of the rule, which can be stored in the database alongside the rule definition.

e.g. Restrict a certain post to moderators and admins.

```php
$post->addAccessControl('view', [
    [
        'class' => \Tanerkay\ModelAcl\Rules\HasRole::class,
        'arguments' => ['admin', 'moderator'],
    ]
]);

// throws exception if $user->hasRole(['admin', 'moderator']) doesn't return true
$post->can('view');
```

The `HasRole` class assumes your `User` model has a method `hasRole()` that accepts a string or an array of strings. You can customize the name of the method using the env key `MODEL_ACL_AUTHENTICATABLE_HAS_ROLE`.

### Creating custom rules

For other rules or logic, you can construct your own Rule class which implements `\Tanerkay\ModelAcl\Contracts\RuleContract` or which extends the abstract class `\Tanerkay\ModelAcl\Rules\Rule`.

e.g.

```php
use Tanerkay\ModelAcl\Rules\Rule;

class AgeRequirementRule extends Rule
{
    public function authorize(?Authenticatable $user, ...$arguments): void
    {
        $user ??= $this->getUser();

        if ($user->date_of_birth->diffInYears() < $arguments[0]) {
            throw new \Exception('Not wise enough');
        }
    }
}
```

```php
$drink = Drink::where('is_alcoholic', true)->first();

$drink->addAccessControl('buy', [
    [
        'class' => AgeRequirementRule::class,
        'arguments' => 18,
    ]
]);

// throws exception if user is under 18 years of age
$drink->can('buy');
```

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
