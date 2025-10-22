<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WorkedSessionController;
use Illuminate\Support\Facades\Route;


Route::resource('projects', ProjectController::class);
Route::resource('tasks', TaskController::class);
Route::resource('sessions', WorkedSessionController::class);

Route::middleware('auth')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/project/{project}', [ProjectController::class, 'show']);
    Route::put('/task/{task}/toggle', [TaskController::class, 'toggleChecked'])->name('task.toggle');
    Route::delete('/project/{id}', [ProjectController::class, 'destroy'])->name('project.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
