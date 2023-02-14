<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductIn extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['branch_id', 'user_id', 'notes', 'date_received'];

    protected static function booted()
    {
        static::creating(function ($productIn) {
            $productIn->user_id = auth()->id();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_in_details')->withPivot('quantity');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
