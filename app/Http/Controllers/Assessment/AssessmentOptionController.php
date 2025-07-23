<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Services\Assessment\AssessmentOptionService;
use Illuminate\Http\Request;

class AssessmentOptionController extends Controller
{
    public function __construct(protected AssessmentOptionService $assessmentOptionService)
    {
        $this->assessmentOptionService = $assessmentOptionService;
    }

    public function index($id, Request $request)
    {
        $options = $this->assessmentOptionService->index($id, $request->query());
        return view('pages.quiz.assessment_option.index', compact('options'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            "assessment_question_id" => "required|exists:assessment_questions,id",
            "text" => "required|string",
            "score_value" => "required|integer",
            "score_conversion" => "required|integer",
        ], [], ["score_value" => "score"]);

        $assessments = $this->assessmentOptionService->store($validate);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to created quiz option");
        } else {
            return redirect()->back()->with('failed', "Failed to created quiz option");
        }
    }

    public function update($id, Request $request)
    {
        $validate = $request->validate([
            "assessment_question_id" => "required|exists:assessment_questions,id",
            "text" => "required|string",
            "score_value" => "required|integer",
            "score_conversion" => "required|integer",
        ], [], ["score_value" => "score"]);

        $assessments = $this->assessmentOptionService->update($id, $validate);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to updated quiz option");
        } else {
            return redirect()->back()->with('failed', "Failed to updated quiz option");
        }
    }

    public function delete($id)
    {
        $assessments = $this->assessmentOptionService->delete($id);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to deleted quiz option");
        } else {
            return redirect()->back()->with('failed', "Failed to deleted quiz option");
        }
    }
}
