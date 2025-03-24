<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResourceController extends Controller
{
    use ValidatesRequests;

    protected $model;

    /**
     * Mostrar todos los recursos.
     */
    public function index()
    {
        try {
            $data = $this->model::all();
            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los datos',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Almacenar un nuevo recurso.
     */
    public function store(Request $request)
    {
        try{
            $model = new $this->model($request->all());
            $this->validate($request, [
                'id' => 'numeric'
            ]);
            $model->save();

        return $model;
        }
        catch(\Exception $e){
            return response()->json(
                [
                    'message' => $e,
                ],
                422
            );
        }
    }

    /**
     * Mostrar un recurso específico.
     */
    public function show($id)
    {
        try {
            $data = $this->model->find($id);

            if (!$data) {
                return response()->json([
                    'message' => 'Recurso no encontrado',
                ], 404);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar el recurso',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Actualizar un recurso existente.
     */
    public function update(Request $request, $id)
    {
        try {

            $model = $this->model::find($id);
            $model->update($request->all());
            //return successful response
            return response()->json([
                        'message' => 'Actualizado',
                        'data' => $model
                    ]);
        } catch (\Exception $e) {
            //return error message
            return response()->json([
                        'message' => 'Error al actualizar',
                        'error' => $e->getMessage(),
                    ], 422);
        }

    }

    /**
     * Eliminar un recurso.
     */
    public function delete($id)
    {
        try{
            $data = $this->model::find($id);
            $data->delete();

            return response()->json(
                [
                    'message' => '$Dato eliminado',
                    'message' => $data
                ],
                200
            );
            /* return response('', 204); */
        }
        catch (\Exception $e) 
        {
            return response()->json([
                'message' => 'Error al eliminar',
                'error' => $e->getMessage(),
            ], 422);
        }
        
    }
}





