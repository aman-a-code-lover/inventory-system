<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $role_id
 * @property int $permission_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['role_id', 'permission_id'])]
class RolePermission extends Model
{
    /** @use HasFactory */
    use HasFactory;

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
