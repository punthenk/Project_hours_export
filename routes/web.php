<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkedSessionController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->group(function () {
    Route::post('/project/{project}/export', [ProjectController::class, 'export'])->name('project.export');

    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/project/{project}', [ProjectController::class, 'show']);
    Route::put('/task/{task}/toggle', [TaskController::class, 'toggleChecked'])->name('task.toggle');
    Route::put('/task/{task}/update', [TaskController::class, 'update'])->name('task.update');
    Route::put('/session/{session}/update', [WorkedSessionController::class, 'update'])->name('session.update');
    Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::resource('projects', ProjectController::class);
Route::resource('tasks', TaskController::class);
Route::resource('sessions', WorkedSessionController::class);

require __DIR__.'/auth.php';
