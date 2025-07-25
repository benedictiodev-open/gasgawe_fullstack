<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Services\Assessment\AssessmentCategoryService;
use Illuminate\Http\Request;

class AssessmentCategoryController extends Controller
{
    public function __construct(protected AssessmentCategoryService $assessmentCategoryService)
    {
        $this->assessmentCategoryService = $assessmentCategoryService;
    }

    public function index($id, Request $request)
    {
        $categories = $this->assessmentCategoryService->index($id, $request->query());
        return view('pages.quiz.assessment_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            "assessment_id" => "required|exists:assessments,id",
            "name" => "required|string",
            "weight" => "required|integer",
            "description" => "required|string",
        ]);

        $assessments = $this->assessmentCategoryService->store($validate);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to created quiz category");
        } else {
            return redirect()->back()->with('failed', "Failed to created quiz category");
        }
    }

    public function update($id, Request $request)
    {
        $validate = $request->validate([
            "assessment_id" => "required|exists:assessments,id",
            "name" => "required|string",
            "weight" => "required|integer",
            "description" => "required|string",
        ]);

        $assessments = $this->assessmentCategoryService->update($id, $validate);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to updated quiz category");
        } else {
            return redirect()->back()->with('failed', "Failed to updated quiz category");
        }
    }

    public function delete($id)
    {
        $assessments = $this->assessmentCategoryService->delete($id);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to deleted quiz category");
        } else {
            return redirect()->back()->with('failed', "Failed to deleted quiz category");
        }
    }
}
