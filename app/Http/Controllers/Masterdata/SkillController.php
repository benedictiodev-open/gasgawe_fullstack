<?php

namespace App\Http\Controllers\Masterdata;

use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\Skill\StoreSkillRequest;
use App\Http\Requests\Masterdata\Skill\UpdateSkillRequest;
use App\Services\Masterdata\SkillService;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.skills.index', [
            'skills' => $this->skillService->getSkill($request, false),
            'skillGroups' => $this->skillService->getSkillGroup($request, true)
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
    public function store(StoreSkillRequest $request)
    {
        try {
            $this->skillService->store($request->validated());

            return redirect()->back()->with('success', 'Skill created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Skill failed.');
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
    public function update(UpdateSkillRequest $request, string $id)
    {
        try {
            $this->skillService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Skill updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Skill failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->skillService->delete($id);

            return redirect()->back()->with('success', 'Skill deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Skill failed.');
        }
    }
}
