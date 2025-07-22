<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\ExpectedSalary\StoreExpectedSalaryRequest;
use App\Http\Requests\Masterdata\ExpectedSalary\UpdateExpectedSalaryRequest;
use App\Services\Masterdata\ExpectedSalaryService;
use Illuminate\Http\Request;

class ExpectedSalaryController extends Controller
{
    protected $expectedSalaryService;

    public function __construct(ExpectedSalaryService $expectedSalaryService)
    {
        $this->expectedSalaryService = $expectedSalaryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.expected-salary.index', [
            'expectedSalaries' => $this->expectedSalaryService->getExpectedSalary($request, false),
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
    public function store(StoreExpectedSalaryRequest $request)
    {
        try {
            $this->expectedSalaryService->store($request->validated());

            return redirect()->back()->with('success', 'Expected Salary created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Expected Salary failed.');
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
    public function update(UpdateExpectedSalaryRequest $request, string $id)
    {
        try {
            $this->expectedSalaryService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Expected Salary updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Expected Salary failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->expectedSalaryService->delete($id);

            return redirect()->back()->with('success', 'Expected Salary deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Expected Salary failed.');
        }
    }
}
