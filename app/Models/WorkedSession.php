<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkedSession extends Model
{
    protected $fillable = [
        'task_id',
        'start_time',
        'end_time',
        'duration',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
