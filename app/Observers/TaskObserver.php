<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        $this->updateProjectWorkedTime($task->project_id);
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        $this->updateProjectWorkedTime($task->project_id);
    }

    public function deleting(Task $task): void
    {
        $task->tempProjectId = $task->project_id;
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        if (isset($task->tempProjectId)) {
            $this->updateProjectWorkedTime($task->tempProjectId);
        } else {
            Log::error('NO PROJECT ID FOUND IN DELETED EVENT');
        }
    }

    private function updateProjectWorkedTime($projectId)
    {
        $project = Project::find($projectId);

        if ($project) {
            // Recalculate total from all remaining tasks
            $totalMinutes = $project->tasks()->sum('worked_time');
            $project->worked_time = round($totalMinutes / 60, 2);
            $project->saveQuietly();
        }
    }
}
