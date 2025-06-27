<?php

namespace App\Http\Controllers\api\Masterdata;

use App\Http\Controllers\Controller;
use App\Services\Masterdata\SkillService;
use App\Traits\ResponseTrait;

class SkillController extends Controller
{
    use ResponseTrait;

    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    /**
     * @OA\Get(
     *     path="/masterdata/skill",
     *     tags={"Masterdata"},
     *     summary="Get all skills",
     *     security={{"bearerAuth":{}}},
     *     description="Retrieve a list of all skills with their group names.",
     *     @OA\Response(
     *         response=200,
     *         description="Skills retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Skill retrieved successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="PHP"),
     *                     @OA\Property(property="skill_group_name", type="string", example="Programming Language")
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
    public function skill()
    {
        try {
            $data = $this->skillService->getSkill();

            return $this->successResponse($data, 'Skill retrieved successfully');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return $this->errorResponse('Internal Server Error', 500);
        }
    }
}
