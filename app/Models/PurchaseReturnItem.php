<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $purchase_return_id
 * @property int $product_id
 * @property string $quantity
 * @property string $unit_price
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['purchase_return_id', 'product_id', 'quantity', 'unit_price', 'reason'])]
class PurchaseReturnItem extends Model
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
            'quantity' => 'decimal:4',
            'unit_price' => 'decimal:2',
        ];
    }

    public function purchase_return(): BelongsTo
    {
        return $this->belongsTo(PurchaseReturn::class, 'purchase_return_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
