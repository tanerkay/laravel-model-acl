<?php

namespace Tanerkay\ModelAcl\Test\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property Collection $roles
 */
class User extends BaseUser
{
    protected $table = 'users';

    protected $fillable = ['id', 'name', 'roles'];

    protected $casts = [
        'roles' => 'collection',
    ];

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
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission(string|array $permissions): bool
    {
        foreach ((array) $permissions as $permission) {
            if ($this->permissions->contains($permission)) {
                return true;
            }
        }

        return false;
    }
}
