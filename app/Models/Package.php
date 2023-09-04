<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name','parent_id'];

    public function getIsPrimaryAttribute()
    {
        return $this->parent_id === null;
    }

    // public function scopePrimary($query)
    // {
    //     return $query->whereNull('parent_id');
    // }

    public function parent()
    {
        return $this->belongsTo(Package::class);
    }

    public function subpackages()
    {
        return $this->hasMany(Package::class, 'parent_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
