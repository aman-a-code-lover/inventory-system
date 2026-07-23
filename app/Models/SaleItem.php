<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $sale_id
 * @property int $product_id
 * @property string $quantity
 * @property string $unit_price
 * @property string $tax_amount
 * @property string $discount_amount
 * @property string|null $lot_number
 * @property Carbon|null $expiry_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['sale_id', 'product_id', 'quantity', 'unit_price', 'tax_amount', 'discount_amount', 'lot_number', 'expiry_date'])]
class SaleItem extends Model
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
            'discount_amount' => 'decimal:2',
            'expiry_date' => 'date',
            'quantity' => 'decimal:4',
            'tax_amount' => 'decimal:2',
            'unit_price' => 'decimal:2',
        ];
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
