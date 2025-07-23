<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Services\Assessment\AssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssessmentController extends Controller
{
    public function __construct(protected AssessmentService $assessmentService)
    {
        $this->assessmentService = $assessmentService;
    }

    public function index(Request $request)
    {
        $assessments = $this->assessmentService->index($request->query());
        return view('pages.quiz.assessment.index', compact('assessments'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required|string",
            "role" => "required|in:applicant,recruiter",
            "total_questions" => "required|number",
            "estimated_duration" => "required|number",
            "estimated_duration" => "required|number",
            "scoring_system" => "required|string",
        ]);

        $assessments = $this->assessmentService->store($validate->getData());

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to created quiz");
        } else {
            return redirect()->back()->with('failed', "Failed to created quiz");
        }
    }

    public function update($id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required|string",
            "role" => "required|in:applicant,recruiter",
            "total_questions" => "required|number",
            "estimated_duration" => "required|number",
            "estimated_duration" => "required|number",
            "scoring_system" => "required|string",
        ]);

        $assessments = $this->assessmentService->update($id, $validate->getData());

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to updated quiz");
        } else {
            return redirect()->back()->with('failed', "Failed to updated quiz");
        }
    }

    public function delete($id)
    {
        $assessments = $this->assessmentService->delete($id);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to deleted quiz");
        } else {
            return redirect()->back()->with('failed', "Failed to deleted quiz");
        }
    }
}
