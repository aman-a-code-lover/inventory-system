<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $supplier_id
 * @property string $reference_no
 * @property string $status
 * @property string $total_amount
 * @property string $tax_amount
 * @property string $discount_amount
 * @property string $paid_amount
 * @property Carbon|null $purchase_date
 * @property Carbon|null $due_date
 * @property int|null $warehouse_id
 * @property int|null $created_by
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['supplier_id', 'reference_no', 'status', 'total_amount', 'tax_amount', 'discount_amount', 'paid_amount', 'purchase_date', 'due_date', 'warehouse_id', 'created_by', 'notes'])]
class Purchase extends Model
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
            'discount_amount' => 'decimal:2',
            'due_date' => 'date',
            'paid_amount' => 'decimal:2',
            'purchase_date' => 'date',
            'tax_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',
        ];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
