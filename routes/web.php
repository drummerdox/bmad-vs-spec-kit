<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::redirect('/dashboard', '/todos');

Route::view('todos', 'todos.index')
    ->middleware(['auth'])
    ->name('todos');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
