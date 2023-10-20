<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'start_date', 'end_date', 'status', 'customer_id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Package::class);
    }

    public function taskItems()
    {
        return $this->hasMany(ProjectTask::class, 'project_id');
    }

    public function taskStatuses()
    {
        return $this->hasMany(ProjectTaskStatus::class, 'project_id');
    }
}
