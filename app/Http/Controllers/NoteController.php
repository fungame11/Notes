<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller {
	// получаем заметки только залогиненного пользователя
    public function index() {
    return response()->json([
        'response' => [
            'data' => Note::where('user_id', auth()->id())->get()
        ]
    ]);
}

        public function show(Note $note) {
        if ($note->user_id !== auth()->id()) abort(403);

        return response()->json([
            'response' => [
                'data' => $note
            ]
        ]);
    }


    public function create(Request $request) {
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $data['done'] = false;
    $data['user_id'] = auth()->id(); // привязываем заметку в пользователю

    $note = Note::create($data);

    return response()->json(['response' => ['data' => $note]]);
}

        public function edit(Request $request, Note $note) {
        if ($note->user_id !== auth()->id()) abort(403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $note->update($data);

        return response()->json([
            'response' => [
                'data' => $note
            ]
        ]);
    }


        public function delete(Note $note) {
        if ($note->user_id !== auth()->id()) abort(403);

        $note->delete();
        
        return response()->json(['success' => true]);
    }
}
