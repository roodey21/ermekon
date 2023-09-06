<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
