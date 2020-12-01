<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeController extends Controller
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
        $employees = Employee::query()
            ->with('company')
            ->paginate($request->per_page);

        return JsonResource::collection($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmployeeRequest  $request
     * @return JsonResource
     */
    public function store(EmployeeRequest $request)
    {
        $employee = Employee::query()
            ->create($request->validated());

        $employee->load('company');

        return new JsonResource($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return JsonResource
     */
    public function show(Employee $employee)
    {
        $employee->load('company');

        return new JsonResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return JsonResource
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->validated());

        $employee->load('company');

        return new JsonResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Employee $employee
     * @return JsonResource
     * @throws \Exception
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return new JsonResource($employee);
    }
}
