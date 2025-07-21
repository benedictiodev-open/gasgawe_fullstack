<?php

namespace App\Http\Controllers\api\Assessment;

use App\Http\Controllers\Controller;
use App\Services\Assessment\AssessmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AssessmentController extends Controller
{
    use ResponseTrait;

    public function __construct(protected AssessmentService $assessmentService)
    {
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
        $data = $this->assessmentService->getAssessment();
        if ($data) {
            return $this->successResponse($data, 'Assessments retrieved successfully.');
        } else {
            return $this->errorResponse('Failed to retrieve assessments.', 500);
        }
    }
}
