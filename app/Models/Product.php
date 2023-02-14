<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'make',
        'brand',
        'model',
        'year_start',
        'year_end',
        'transmission',
        'thickness_number',
        'thickness',
        'stock_number',
        'enterex_price',
        'price',
        'notes',
    ];

    protected $appends = ['detail'];

    protected function enterexPrice(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value / 100,
            set: fn($value) => $value * 100,
        );
    }
    
    protected function detail(): Attribute
    {
        $withHyphen = ($this->year_start && $this->year_end) ? '-' : '';

        return Attribute::make(
            get: fn() => $this->stock_number . ' ' . 
                            $this->brand . ' ' . 
                            $this->model . ' ' . 
                            $this->year_start . 
                            $withHyphen .
                            $this->year_end . ' ' . 
                            $this->transmission . ' ' .
                            $this->thickness_number . ' ' .
                            $this->thickness
        );
    }

    public function productIns(): BelongsToMany
    {
        return $this->belongsToMany(ProductIn::class, 'product_in_details');
    }
}
