<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResourceController extends Controller
{
    use ValidatesRequests;

    /**
     * Servicio que gestiona la lógica de negocio.
     * Debe definirse en el controlador hijo.
     */
    protected $service;

    /**
     * Mostrar todos los recursos.
     */
    public function index()
    {
        return response()->json($this->service->getAll());
    }

    /**
     * Almacenar un nuevo recurso.
     */
    public function store(Request $request)
    {
        try {
            $model = $this->service->create($request->all());

            return response()->json([
                'message' => 'Creado',
                'data' => $model
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al guardar el recurso',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Mostrar un recurso específico.
     */
    public function show($id)
    {
        return response()->json($this->service->find($id));
    }

    /**
     * Actualizar un recurso existente.
     */
    public function update(Request $request, $id)
    {
        try {
            $model = $this->service->update($id, $request->all());

            return response()->json([
                'message' => 'Actualizado',
                'data' => $model
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Eliminar un recurso.
     */
    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return response()->json([
                'message' => 'Eliminado'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar',
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}
