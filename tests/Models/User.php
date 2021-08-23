<?php

namespace Tanerkay\ModelAcl\Test\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property Collection $roles
 */
class User extends Model implements Authenticatable
{
    protected $table = 'users';

    protected $fillable = ['id', 'name', 'roles'];

    protected $casts = [
        'roles' => 'collection',
    ];

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): mixed
    {
        $name = $this->getAuthIdentifierName();

        return $this->attributes[$name];
    }

    public function getAuthPassword(): string
    {
        return $this->attributes['password'];
    }

    public function getRememberToken(): string
    {
        return 'token';
    }

    public function setRememberToken($value): void
    {
        // ...
    }

    public function getRememberTokenName(): string
    {
        return 'tokenName';
    }

    public function nodes(): HasMany
    {
        return $this->hasMany(Node::class);
    }

    public function latestNode(): HasOne
    {
        return $this->hasOne(Node::class)->latestOfMany();
    }

    public function hasRole(string|array $roles): bool
    {
        foreach ((array) $roles as $role) {
            if (! $this->roles->contains($role)) {
                return false;
            }
        }

        return true;
    }
}
