<?php

namespace App\Http\Controllers\api\Masterdata;

use App\Http\Controllers\Controller;
use App\Services\Masterdata\BadgeService;
use App\Traits\ResponseTrait;

class BadgeController extends Controller
{
    use ResponseTrait;

    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    /**
     * @OA\Get(
     *     path="/masterdata/badge/applicant",
     *     tags={"Masterdata"},
     *     summary="Get all applicant badges",
     *     security={{"bearerAuth":{}}},
     *     description="Retrieve a list of all applicant badges.",
     *     @OA\Response(
     *         response=200,
     *         description="Badges retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Badge retrieved successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="PHP"),
     *                     @OA\Property(property="description", type="string", example="PHP description"),
     *                     @OA\Property(property="image_path", type="string", example="badges/Applicant_timestamp.jpg")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function applicant()
    {
        try {
            $data = $this->badgeService->getApplicantBadge();

            return $this->successResponse($data, 'Badge retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/masterdata/badge/recruiter",
     *     tags={"Masterdata"},
     *     summary="Get all recruiter badges",
     *     security={{"bearerAuth":{}}},
     *     description="Retrieve a list of all recruiter badges.",
     *     @OA\Response(
     *         response=200,
     *         description="Badges retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Badge retrieved successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="PHP"),
     *                     @OA\Property(property="description", type="string", example="PHP description"),
     *                     @OA\Property(property="image_path", type="string", example="badges/Recruiter_timestamp.jpg")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Internal Server Error")
     *         )
     *     )
     * )
     */
    public function recruiter()
    {
        try {
            $data = $this->badgeService->getRecruiterBadge();

            return $this->successResponse($data, 'Badge retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
