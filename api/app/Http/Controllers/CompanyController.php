<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends ResourceController
{
    protected $model = Company::class;

    public function index()
    {
        try {
            $companies = $this->model::with('contacts')->get();
            return response()->json($companies, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al obtener las compañías',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255'
            ]);

            return parent::store(new Request($data));
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al almacenar la compañía',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $company = $this->model::with('contacts', 'notes')->find($id);

            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            return response()->json($company);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al mostrar la compañía',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'name' => 'sometimes|required|string|max:255'
            ]);

            return parent::update(new Request($data), $id);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar la compañía',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $deleted = parent::delete($id);

            if (!$deleted) {
                return response()->json(['message' => 'Company not found or could not be deleted'], 404);
            }

            return response()->json(['message' => 'Company deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar la compañía',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}