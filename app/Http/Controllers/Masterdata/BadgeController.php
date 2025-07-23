<?php

namespace App\Http\Controllers\Masterdata;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Masterdata\Badge\StoreBadgeRequest;
use App\Http\Requests\Masterdata\Badge\UpdateBadgeRequest;
use App\Services\Masterdata\BadgeService;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.masterdata.badge.index', [
            'badges' => $this->badgeService->getBadge($request, false),
            'userTypes' => UserTypeEnum::toSelectOptions()
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
    public function store(StoreBadgeRequest $request)
    {
        try {
            $this->badgeService->store($request->validated());

            return redirect()->back()->with('success', 'Badge created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Create Badge failed.');
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
    public function update(UpdateBadgeRequest $request, string $id)
    {
        try {
            $this->badgeService->update($id, $request->validated());

            return redirect()->back()->with('success', 'Badge updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Update Badge failed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->badgeService->delete($id);

            return redirect()->back()->with('success', 'Badge deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('failed', 'Delete Badge failed.');
        }
    }
}
