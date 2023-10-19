<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status_id', 'start_date', 'due_date', 'completed_date', 'created_by'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
