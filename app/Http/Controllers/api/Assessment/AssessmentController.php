<?php

namespace App\Http\Controllers\api\Assessment;

use App\Http\Controllers\Controller;
use App\Services\Assessment\AssessmentQuestionService;
use App\Services\Assessment\AssessmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    use ResponseTrait;

    public function __construct(
        protected AssessmentQuestionService $assessmentQuestionService,
        protected AssessmentService $assessmentService
    ) {
        $this->assessmentQuestionService = $assessmentQuestionService;
        $this->assessmentService = $assessmentService;
    }


    /**
     * @OA\Get(
     *     path="/applicant/assessment",
     *     tags={"Applicant Assessment"},
     *     summary="Get Applicant Assessments",
     *     description="Retrieve a list of all assessments.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Assessments retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Assessments retrieved successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean", example=false),
     *         )
     *     ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(
     *            @OA\Property(property="status", type="int", example=401),
     *            @OA\Property(property="message", type="string", example="Unauthorized User"),
     *        )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve assessments",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Failed to retrieve assessments"),
     *              @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $data = $this->assessmentQuestionService->getQuestionAssessment();
        if ($data) {
            return $this->successResponse($data, 'Assessments retrieved successfully.');
        } else {
            return $this->errorResponse('Failed to retrieve assessments.', 500);
        }
    }

    /**
     * @OA\PUT(
     *     path="/applicant/assessment/score",
     *     tags={"Applicant Assessment"},
     *     summary="Update a calculate Score of Applicant Assessments",
     *     description="Update a calculate score of applicant assessments.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Score Assessments updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Score Assessments updated successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean", example=false),
     *         )
     *     ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(
     *            @OA\Property(property="status", type="int", example=401),
     *            @OA\Property(property="message", type="string", example="Unauthorized User"),
     *        )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to updated score assessments",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Failed to updated score assessments"),
     *              @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         )
     *     )
     * )
     */
    public function update(): JsonResponse
    {
        $data = $this->assessmentService->calculateScore(Auth::guard('sanctum')->user()->id);
        if ($data) {
            return $this->successResponse($data, 'Score Assessments updated successfully.');
        } else {
            return $this->errorResponse('Failed to updated score assessments.', 500);
        }
    }

    /**
     * @OA\POST(
     *     path="/applicant/assessment/answer",
     *     tags={"Applicant Assessment"},
     *     summary="Submit an answer to an assessment question",
     *     description="Submit an answer to an assessment question.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="question_id", type="integer", example=1),
     *             @OA\Property(property="option_id", type="integer", example=1),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Answer submitted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Answer submitted successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean", example=false),
     *         )
     *     ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *        @OA\JsonContent(
     *            @OA\Property(property="status", type="int", example=401),
     *            @OA\Property(property="message", type="string", example="Unauthorized User"),
     *        )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to submit answer",
     *         @OA\JsonContent(
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Failed to submit answer"),
     *              @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         )
     *     )
     * )
     */
    public function answer(Request $request)
    {
        $validate = $request->validate([
            "user_id" => "required|number",
            "question_id" => "required|number",
            "option_id" => "required|number",
        ]);

        $answer = $this->assessmentService->answer($validate);

        if ($answer) {
            return response()->json(['message' => 'Answer submitted successfully']);
        } else {
            return response()->json(['message' => 'Failed to submit answer'], 500);
        }
        return response()->json(['message' => 'Failed to submit answer'], 500);
    }
}
