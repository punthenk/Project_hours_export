<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'completed',
        'worked_time',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
