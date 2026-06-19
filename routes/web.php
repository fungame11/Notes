<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::get('/notes', [PagesController::class, 'index'])->name('notes.index');
Route::get('/notes/create', [PagesController::class, 'create'])->name('notes.create');
Route::get('/notes/{id}/edit', [PagesController::class, 'edit'])->name('notes.edit');

Route::redirect('/', '/notes');
