<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller {
    public function index() {
        return response()->json([
            'response' => [
                'data' => Note::all()
            ]
        ]);
    }

    public function show(Note $note) {
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
        $note = Note::create($data);

        return response()->json([
            'response' => [
                'data' => $note
            ]
        ]);
    }

    public function edit(Request $request, Note $note) {
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
        $note->delete();
        return response()->json(['success' => true]);
    }
}
