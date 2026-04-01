<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\TaskController; 

Route::get('/', function () {
    return redirect()->route('home');
});

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// for logged in users
Route::middleware(['auth'])->group(function () { // this means all routes inside this block can only be accessed if the user is logged in
    Route::get('/tasks', [TaskController::class, 'index'])->name('home'); //runs index(), which gets all tasks and returns them to the frontend
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store'); //runs store(), which validates input and saves a new task to the database
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update'); //runs update(), which finds a task by ID and updates its fields
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy'); //runs destroy(), which finds a task by ID and deletes it from the database
});

// Public task routes (no auth required for now)
// Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
// Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
// Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
// Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
