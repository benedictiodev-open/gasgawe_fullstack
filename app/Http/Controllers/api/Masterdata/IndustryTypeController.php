<?php

namespace App\Http\Controllers\api\Masterdata;

use App\Http\Controllers\Controller;
use App\Models\IndustryType;
use Illuminate\Http\Request;

class IndustryTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/masterdata/industry-types",
     *     tags={"Masterdata"},
     *     summary="Get all industry types",
     *     description="Retrieve a list of all active industry types.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Industry types retrieved successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object", @OA\Property(property="id", type="integer"), @OA\Property(property="name", type="string"), @OA\Property(property="description", type="string", nullable=true))),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),     
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to fetch industry types"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     * )
     */ 
    public function index()
    {
        try {
            $industryTypes = IndustryType::active()->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Industry types retrieved successfully',
                'data' => $industryTypes
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch industry types',
                'data' => null
            ], 500);
        }
    }
}
