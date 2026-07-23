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
 * @property int|null $parent_id
 * @property string $name
 * @property string|null $slug
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['parent_id', 'name', 'slug', 'description'])]
class Category extends Model
{
    /** @use HasFactory */
    use HasFactory, SoftDeletes;

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
