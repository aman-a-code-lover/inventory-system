<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property int|null $warehouse_id
 * @property string $movement_type
 * @property int|null $reference_id
 * @property int|null $purchase_id
 * @property int|null $sale_id
 * @property int|null $purchase_return_id
 * @property int|null $sale_return_id
 * @property int|null $stock_adjustment_id
 * @property string $quantity
 * @property string|null $unit_cost
 * @property string|null $balance_after
 * @property string|null $note
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['product_id', 'warehouse_id', 'movement_type', 'reference_id', 'purchase_id', 'sale_id', 'purchase_return_id', 'sale_return_id', 'stock_adjustment_id', 'quantity', 'unit_cost', 'balance_after', 'note', 'created_by'])]
class StockMovement extends Model
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
            'balance_after' => 'decimal:4',
            'quantity' => 'decimal:4',
            'unit_cost' => 'decimal:2',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function purchase_return(): BelongsTo
    {
        return $this->belongsTo(PurchaseReturn::class, 'purchase_return_id');
    }

    public function sale_return(): BelongsTo
    {
        return $this->belongsTo(SaleReturn::class, 'sale_return_id');
    }

    public function stock_adjustment(): BelongsTo
    {
        return $this->belongsTo(StockAdjustment::class, 'stock_adjustment_id');
    }
}
