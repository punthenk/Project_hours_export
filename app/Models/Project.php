<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'worked_time',
    ];

    public function updateWorkedTime()
    {
        $total_minutes = $this->tasks()->sum('worked_time');
        $this->worked_time = round($total_minutes / 60, 2); // 2 decimalen, bv. 6.40
        $this->saveQuietly();
    }

    public function getCompletedTasksCountAttribute()
    {
        return $this->tasks->filter(fn($task) => $task->completed)->count();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
