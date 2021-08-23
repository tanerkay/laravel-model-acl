<?php

namespace Tanerkay\ModelAcl\Test\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tanerkay\ModelAcl\Traits\ModelBasedAccessControl;

/**
 * @property int $id
 * @property string $name
 * @property User $user
 */
class Node extends Model
{
    use ModelBasedAccessControl;

    protected $table = 'nodes';

    protected $fillable = ['id', 'name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
