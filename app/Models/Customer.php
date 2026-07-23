<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $contact_person
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
#[Fillable(['name', 'code', 'email', 'phone', 'address', 'contact_person', 'notes'])]
class Customer extends Model
{
    /** @use HasFactory */
    use HasFactory, SoftDeletes;
}
