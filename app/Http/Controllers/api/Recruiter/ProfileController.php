<?php

namespace App\Http\Controllers\api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruiter\UpdateProfileRequest;
use App\Services\Recruiter\ProfileService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ResponseTrait;

    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * @OA\Get(
     *     path="/recruiter/profile",
     *     summary="Get recruiter profile",
     *     tags={"Recruiter"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Profile retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="company_name", type="string", example="perusahaan keluarga"),
     *                 @OA\Property(property="established_date", type="string", format="date-time", example="2020-04-21T17:00:00.000000Z"),
     *                 @OA\Property(property="province_id", type="integer", example=12),
     *                 @OA\Property(property="city_id", type="integer", example=181),
     *                 @OA\Property(property="bio", type="string", example="bio bio bio perusahaan"),
     *                 @OA\Property(property="file_profile_image", type="string", example="recruiter_files/profile_image/profile_image_1_1751385624.png"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-01T15:51:00.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-01T16:00:24.000000Z"),
     *                 @OA\Property(property="employee_count", type="integer", example=100),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve profile",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to retrieve profile"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function getProfile()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $profile = $this->profileService->getProfile($user);

            if (!$profile) {
                return $this->errorResponse('Profile not found', 404);
            }

            return $this->successResponse($profile, 'Profile retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Service Unavailable', 503);
        }
    }

    /**
     * @OA\Post(
     *     path="/recruiter/profile",
     *     summary="Update recruiter profile",
     *     tags={"Recruiter"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"company_name", "established_date", "province_id", "city_id", "employee_count", "bio"},
     *
     *                 @OA\Property(property="company_name", type="string", example="nama perusahaan"),
     *                 @OA\Property(property="established_date", type="string", format="date", example="2020-04-22"),
     *                 @OA\Property(property="province_id", type="integer", example=12),
     *                 @OA\Property(property="city_id", type="integer", example=181),
     *                 @OA\Property(property="employee_count", type="integer", example=100),
     *                 @OA\Property(property="bio", type="string", example="bio perusahaan"),
     *                 @OA\Property(property="file_profile_image", type="file", format="binary", description="Profile image file (JPG, PNG, max 2MB)"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Profile updated successfully"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();

            $validated = $request->validated();

            $profile = $this->profileService->updateProfile($user, $validated);

            return $this->successResponse($profile, 'Profile updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Service Unavailable', 503);
        }
    }
}
