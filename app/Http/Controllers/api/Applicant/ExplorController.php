<?php

namespace App\Http\Controllers\api\Applicant;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;

class ExplorController extends Controller
{
    /**
     * @OA\GET(
     *     path="/applicant/explor",
     *     tags={"Applicant Explor"},
     *     summary="Get all explor",
     *     description="Get all explor company.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Explor retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),   
     *             @OA\Property(property="message", type="string", example="Explor retrieved successfully"),
     *             @OA\Property(property="data", type="array", 
     *                  @OA\Items(type="object", 
     *                      @OA\Property(property="id", type="integer", example=1), 
     *                      @OA\Property(property="user_id", type="integer", example=1), 
     *                      @OA\Property(property="title", type="string", example="title"), 
     *                      @OA\Property(property="description", type="string", example="description"), 
     *                      @OA\Property(property="created_at", type="string", example="2021-01-01 00:00:00"), 
     *                      @OA\Property(property="updated_at", type="string", example="2021-01-01 00:00:00"),
     *                      @OA\Property(property="user", type="object", 
     *                          @OA\Property(property="id", type="integer", example=1), 
     *                          @OA\Property(property="name", type="string", example="name"), 
     *                          @OA\Property(property="email", type="string", example="email"), 
     *                          @OA\Property(property="phone", type="string", example="phone"), 
     *                          @OA\Property(property="address", type="string", example="address"), 
     *                          @OA\Property(property="created_at", type="string", example="2021-01-01 00:00:00"), 
     *                          @OA\Property(property="updated_at", type="string", example="2021-01-01 00:00:00"),
     *                          @OA\Property(property="profileCompany", type="object", 
     *                              @OA\Property(property="id", type="integer", example=1), 
     *                              @OA\Property(property="user_id", type="integer", example=1), 
     *                              @OA\Property(property="province_id", type="integer", example=1), 
     *                              @OA\Property(property="city_id", type="integer", example=1), 
     *                              @OA\Property(property="created_at", type="string", example="2021-01-01 00:00:00"), 
     *                              @OA\Property(property="updated_at", type="string", example="2021-01-01 00:00:00"),
     *                              @OA\Property(property="province", type="object", 
     *                                  @OA\Property(property="id", type="integer", example=1), 
     *                                  @OA\Property(property="name", type="string", example="name"), 
     *                              ),
     *                              @OA\Property(property="city", type="object", 
     *                                  @OA\Property(property="id", type="integer", example=1), 
     *                                  @OA\Property(property="name", type="string", example="name"), 
     *                              ),
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *          ),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation company Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     * ) 
     */
    public function explode()
    {
        try {
            $vidio = Video::with('user', 'user.profileCompany', 'user.profileCompany.province', 'user.profileCompany.city',)
                ->whereHas('user', function($query) {
                    $query->where('type', 'recruiter');
                })->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Get data explor successfully',
                'data' => $vidio
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get explor: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
