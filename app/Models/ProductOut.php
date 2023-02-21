<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductOut extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['branch_id', 'user_id', 'notes', 'date_issued'];

    protected static function booted()
    {
        static::creating(function ($productIn) {
            $productIn->user_id = auth()->id();
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_out_details')->withPivot('quantity', 'price_sold')->using(ProductOutDetail::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
