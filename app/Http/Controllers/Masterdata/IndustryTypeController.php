<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\IndustryType\StoreIndustryTypeRequest;
use App\Http\Requests\Masterdata\IndustryType\UpdateIndustryTypeRequest;
use App\Services\Masterdata\IndustryTypeService;
use Illuminate\Http\Request;

class IndustryTypeController extends Controller
{
    protected $industryTypeService;

    public function __construct(IndustryTypeService $industryTypeService)
    {
        $this->industryTypeService = $industryTypeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.industry-type.index', [
            'industryTypes' => $this->industryTypeService->getIndustryType($request, false),
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
    public function store(StoreIndustryTypeRequest $request)
    {
        try {
            $this->industryTypeService->store($request->validated());

            return redirect()->back()->with('success', 'Industry Type created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Industry Type failed.');
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
    public function update(UpdateIndustryTypeRequest $request, string $id)
    {
        try {
            $this->industryTypeService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Industry Type updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Industry Type failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->industryTypeService->delete($id);

            return redirect()->back()->with('success', 'Industry Type deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Industry Type failed.');
        }
    }
}
