<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/notes', [NoteController::class, 'index']);
Route::get('/notes/{note}', [NoteController::class, 'show']);
Route::post('/notes', [NoteController::class, 'create']);
Route::put('/notes/{note}', [NoteController::class, 'edit']);
Route::delete('/notes/{note}', [NoteController::class, 'delete']);
