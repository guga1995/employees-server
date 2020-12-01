<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([
           'index', 'show'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $companies = Company::query()->paginate($request->per_page);

        return JsonResource::collection($companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest  $request
     * @return JsonResource
     */
    public function store(CompanyRequest $request)
    {
        $company = Company::query()
            ->create($request->validated());

        return new JsonResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return JsonResource
     */
    public function show(Company $company)
    {
        return new JsonResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return JsonResource
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());

        return new JsonResource($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return JsonResource
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return new JsonResource($company);
    }
}
