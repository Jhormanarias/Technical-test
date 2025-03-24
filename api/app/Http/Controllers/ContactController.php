<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends ResourceController
{
    protected $model = Contact::class;

    public function index()
    {
        try {
            $contacts = $this->model::with('company', 'notes')->get();
    
            return response()->json($contacts, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los contactos',
                'error' => $e->getMessage(),
            ], 500);
        }
    
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'company_id' => 'required|exists:companies,id',
                'name'       => 'required|string|max:255',
                'email'      => 'nullable|email',
                'phone'      => 'nullable|string|max:20',
            ]);

            return parent::store(new Request($data));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al almacenar el contacto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $contact = $this->model::with('company', 'notes')->find($id);

            if (!$contact) {
                return response()->json(['message' => 'Contact not found'], 404);
            }

            return response()->json($contact);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el contacto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'company_id' => 'sometimes|exists:companies,id',
                'name'       => 'sometimes|required|string|max:255',
                'email'      => 'nullable|email',
                'phone'      => 'nullable|string|max:20',
            ]);

            return parent::update(new Request($data), $id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el contacto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = parent::delete($id);

            if (!$deleted) {
                return response()->json(['message' => 'Contact not found or could not be deleted'], 404);
            }

            return response()->json(['message' => 'Contact deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el contacto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}