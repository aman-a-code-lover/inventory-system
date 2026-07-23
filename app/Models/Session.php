<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string $payload
 * @property int $last_activity
 */
#[Fillable(['id', 'user_id', 'ip_address', 'user_agent', 'payload', 'last_activity'])]
class Session extends Model
{
    /** @use HasFactory */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
