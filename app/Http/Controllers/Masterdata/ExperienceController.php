<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\Experience\StoreExperienceRequest;
use App\Http\Requests\Masterdata\Experience\UpdateExperienceRequest;
use App\Services\Masterdata\ExperienceService;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    protected $experienceService;

    public function __construct(ExperienceService $experienceService)
    {
        $this->experienceService = $experienceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.experience.index', [
            'experiences' => $this->experienceService->getExperience($request, false),
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
    public function store(StoreExperienceRequest $request)
    {
        try {
            $this->experienceService->store($request->validated());

            return redirect()->back()->with('success', 'Experience created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Experience failed.');
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
    public function update(UpdateExperienceRequest $request, string $id)
    {
        try {
            $this->experienceService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Experience updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Experience failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->experienceService->delete($id);

            return redirect()->back()->with('success', 'Experience deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Experience failed.');
        }
    }
}
