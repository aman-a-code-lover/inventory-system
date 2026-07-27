<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $website
 * @property string|null $contact_person
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['name', 'code', 'email', 'phone', 'address', 'website', 'contact_person', 'notes'])]
class Supplier extends Model
{
    /** @use HasFactory */
    use HasFactory, SoftDeletes;
    /**
     * Product suppliers
     */
    public function productSuppliers(): HasMany
    {
        return $this->hasMany(ProductSupplier::class);
    }


    /**
     * Products supplied by supplier
     */
    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot([
                'supplier_sku',
                'supplier_cost',
                'lead_time_days',
                'is_primary',
            ])
            ->withTimestamps();
    }
}
