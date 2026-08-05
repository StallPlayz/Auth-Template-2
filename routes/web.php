<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
route::patch('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

require __DIR__.'/settings.php';
