<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $sku
 * @property string|null $barcode
 * @property string $name
 * @property string|null $description
 * @property int|null $brand_id
 * @property int|null $category_id
 * @property int|null $unit_id
 * @property string $cost_price
 * @property string $sell_price
 * @property string $reorder_level
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['sku', 'barcode', 'name', 'description', 'brand_id', 'category_id', 'unit_id', 'cost_price', 'sell_price', 'reorder_level', 'is_active'])]
class Product extends Model
{
    /** @use HasFactory */
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cost_price' => 'decimal:2',
            'is_active' => 'boolean',
            'reorder_level' => 'decimal:4',
            'sell_price' => 'decimal:2',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Product suppliers
     */
    public function productSuppliers(): HasMany
    {
        return $this->hasMany(ProductSupplier::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_suppliers')
            ->withPivot([
                'supplier_sku',
                'supplier_cost',
                'lead_time_days',
            ])
            ->withTimestamps();
    }
}
