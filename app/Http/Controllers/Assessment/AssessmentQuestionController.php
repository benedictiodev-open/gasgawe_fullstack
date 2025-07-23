<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Services\Assessment\AssessmentQuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AssessmentQuestionController extends Controller
{
    public function __construct(protected AssessmentQuestionService $assessmentQuestionService)
    {
        $this->assessmentQuestionService = $assessmentQuestionService;
    }

    public function index($id, Request $request)
    {
        $questions = $this->assessmentQuestionService->index($id, $request->query());
        return view('pages.quiz.assessment_question.index', compact('questions'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            "assessment_category_id" => "required|exists:assessment_categories,id",
            "text" => "required|string",
            "question_type" => "required|string",
        ]);

        $assessments = $this->assessmentQuestionService->store($validate);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to created quiz question");
        } else {
            return redirect()->back()->with('failed', "Failed to created quiz question");
        }
    }

    public function update($id, Request $request)
    {
        $validate = $request->validate([
            "assessment_category_id" => "required|exists:assessment_categories,id",
            "text" => "required|string",
            "question_type" => "required|string",
        ]);

        $assessments = $this->assessmentQuestionService->update($id, $validate);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to updated quiz question");
        } else {
            return redirect()->back()->with('failed', "Failed to updated quiz question");
        }
    }

    public function delete($id)
    {
        $assessments = $this->assessmentQuestionService->delete($id);

        if ($assessments) {
            return redirect()->back()->with('success', "Successfully to deleted quiz question");
        } else {
            return redirect()->back()->with('failed', "Failed to deleted quiz question");
        }
    }
}
