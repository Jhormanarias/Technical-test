<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'content' => 'required|string',
                'noteable_id' => 'required|integer',
                'noteable_type' => 'required|string',
            ]);

            $note = Note::create($data);

            return response()->json($note, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        try {
            $notes = Note::all();
            return response()->json($notes);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las notas',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $note = Note::find($id);

            if (!$note) {
                return response()->json(['message' => 'Nota no encontrada'], 404);
            }

            return response()->json($note);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $note = Note::find($id);

            if (!$note) {
                return response()->json(['message' => 'Nota no encontrada'], 404);
            }

            $data = $request->validate([
                'content' => 'sometimes|required|string',
            ]);

            $note->update($data);

            return response()->json($note);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $note = Note::find($id);

            if (!$note) {
                return response()->json(['message' => 'Nota no encontrada'], 404);
            }

            $note->delete();

            return response()->json(['message' => 'Nota eliminada exitosamente']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_in_model(Request $request)
    {
        try {
            Log::info("este es el request: ", ["request" => $request]);

            $data = $request->validate([
                'content' => 'sometimes|required|string',
                'noteable_id' => 'required|integer',
                'noteable_type' => 'required|string',
            ]);

            // Buscar la nota basada en modelo asociado
            $note = Note::where('noteable_id', $data['noteable_id'])
                ->where('noteable_type', $data['noteable_type'])
                ->firstOrFail();

            Log::info("este es el modelo: ", ["Note" => $note]);

            if (!$note) {
                return response()->json(['message' => 'Nota no encontrada'], 404);
            }

            // Actualizar la nota
            $note->update([
                'content' => $data['content'],
            ]);

            return response()->json($note);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la nota',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}