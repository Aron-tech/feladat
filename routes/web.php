<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

Route::controller(ProjectController::class)->prefix('projects')->name('projects.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'edit')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/{project}/edit', 'edit')->name('edit');
    Route::put('/{project}', 'update')->name('update');
});
