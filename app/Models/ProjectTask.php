<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ProjectTask extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'description', 'status_id', 'start_date', 'due_date', 'completed_date', 'assignees', 'created_by'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
