<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends ResourceController
{
    protected $model = Company::class;

    public function __construct(CompanyService $companyService)
    {
        $this->service = $companyService;
    }

    public function index()
    {
        $companies = $this->service->all();
        return response()->json($companies);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        return parent::store(new Request($data));
    }

    public function show($id)
    {
        $company = $this->service->find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found'], 404);
        }

        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255'
        ]);

        return parent::update(new Request($data), $id);
    }

    public function destroy($id)
    {
        $deleted = $this->service->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Company not found or could not be deleted'], 404);
        }

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
