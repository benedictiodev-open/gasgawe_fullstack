<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\Education\StoreEducationRequest;
use App\Http\Requests\Masterdata\Education\UpdateEducationRequest;
use App\Services\Masterdata\EducationService;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    protected $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.education.index', [
            'educations' => $this->educationService->getEducation($request, false),
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
    public function store(StoreEducationRequest $request)
    {
        try {
            $this->educationService->store($request->validated());

            return redirect()->back()->with('success', 'Education created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Education failed.');
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
    public function update(UpdateEducationRequest $request, string $id)
    {
        try {
            $this->educationService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Education updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Education failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->educationService->delete($id);

            return redirect()->back()->with('success', 'Education deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Education failed.');
        }
    }
}
