<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkedSession extends Model
{
    protected $fillable = [
        'task_id',
        'started_at',
        'stopped_at',
        'duration',
        'created_at',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
