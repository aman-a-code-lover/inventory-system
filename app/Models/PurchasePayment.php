<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $purchase_id
 * @property string $amount
 * @property Carbon|null $paid_at
 * @property string|null $method
 * @property string|null $reference
 * @property int|null $created_by
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['purchase_id', 'amount', 'paid_at', 'method', 'reference', 'created_by', 'notes'])]
class PurchasePayment extends Model
{
    /** @use HasFactory */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }
}
