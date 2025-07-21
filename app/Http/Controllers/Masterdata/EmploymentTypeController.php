<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\EmploymentType\StoreEmploymentTypeRequest;
use App\Http\Requests\Masterdata\EmploymentType\UpdateEmploymentTypeRequest;
use App\Services\Masterdata\EmploymentTypeService;
use Illuminate\Http\Request;

class EmploymentTypeController extends Controller
{
    protected $employmentTypeService;

    public function __construct(EmploymentTypeService $employmentTypeService)
    {
        $this->employmentTypeService = $employmentTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.employment-type.index', [
            'employmentTypes' => $this->employmentTypeService->getEmploymentType($request, false),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmploymentTypeRequest $request)
    {
        try {
            $this->employmentTypeService->store($request->validated());

            return redirect()->back()->with('success', 'Employment Type created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Employment Type failed.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmploymentTypeRequest $request, string $id)
    {
        try {
            $this->employmentTypeService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Employment Type updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Employment Type failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->employmentTypeService->delete($id);

            return redirect()->back()->with('success', 'Employment Type deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Employment Type failed.');
        }
    }
}
