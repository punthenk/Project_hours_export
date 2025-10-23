<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'name',
        'description',
        'completed',
        'worked_time',
    ];

    public function updateWorkedTime()
    {
        $total = $this->workedSession()->sum('duration');
        $this->worked_time = $total;
        $this->saveQuietly();

        $this->project->updateWorkedTime();
    }

    public function workedSession()
    {
        return $this->hasMany(WorkedSession::class);
    }


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
