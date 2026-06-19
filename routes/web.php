<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\NoteController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::redirect('/', '/login');

Route::middleware(['auth', 'blocked'])->group(function () {
	
	Route::redirect('/dashboard', '/notes')->name('dashboard');
	
    Route::get('/notes', [PagesController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [PagesController::class, 'create'])->name('notes.create');
    Route::get('/notes/{id}/edit', [PagesController::class, 'edit'])->name('notes.edit');

    Route::get('/api/notes', [NoteController::class, 'index']);
    Route::get('/api/notes/{note}', [NoteController::class, 'show']);
    Route::post('/api/notes', [NoteController::class, 'create']);
    Route::put('/api/notes/{note}', [NoteController::class, 'edit']);
    Route::delete('/api/notes/{note}', [NoteController::class, 'delete']);

    Route::get('/admin', function() {
        if(!auth()->user()->is_admin) abort(403);
        return view('admin.index', ['users' => User::where('id', '!=', auth()->id())->get()]);
    });

        Route::post('/admin/block/{user}', function(\App\Models\User $user) {
        if(!auth()->user()->is_admin) abort(403);
        
        $user->is_blocked = !$user->is_blocked;
        $user->save();
        
        return back();
    });
});

require __DIR__.'/auth.php';
