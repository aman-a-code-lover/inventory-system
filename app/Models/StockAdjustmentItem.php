<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $stock_adjustment_id
 * @property int $product_id
 * @property string $quantity_before
 * @property string $quantity_after
 * @property string $adjustment_quantity
 * @property string|null $reason
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['stock_adjustment_id', 'product_id', 'quantity_before', 'quantity_after', 'adjustment_quantity', 'reason'])]
class StockAdjustmentItem extends Model
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
            'adjustment_quantity' => 'decimal:4',
            'quantity_after' => 'decimal:4',
            'quantity_before' => 'decimal:4',
        ];
    }

    public function stock_adjustment(): BelongsTo
    {
        return $this->belongsTo(StockAdjustment::class, 'stock_adjustment_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
