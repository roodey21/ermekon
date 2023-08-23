<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->code) {
                $year = now()->format('y');
                $maxSequenceNumber = static::whereYear('created_at', now()->year)->where('code', 'LIKE', $year.'%')->max('code' ?? 0);
                if($maxSequenceNumber == 0) {
                    $model->code = $year.str_pad($maxSequenceNumber + 1, 5, '0', STR_PAD_LEFT);
                } else {
                    $model->code = str_pad($maxSequenceNumber + 1, 5, '0', STR_PAD_LEFT);
                }
            }
        });
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'model', 'model_has_categories');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'product_units')->withPivot('conversion_factor');
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function getMainUnitAttribute()
    {
        return $this->units()->where('conversion_factor', 1)->first();
    }

    public function getMainUnitNameAttribute()
    {
        return $this->main_unit->name ?? '';
    }

    public function getConversionUnitsAttribute()
    {
        return $this->units()->where('conversion_factor', '!=', 1)->get();
    }
}
