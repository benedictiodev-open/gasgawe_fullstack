<?php

namespace App\Http\Controllers\api\Applicant;

use App\Http\Controllers\Controller;
use App\Services\Applicant\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * @OA\Put(
     *     path="/applicant/profile/update",
     *     tags={"Applicant"},
     *     summary="Update applicant profile",
     *     description="Update the authenticated applicant's profile information.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", example="1990-05-15"),
     *             @OA\Property(property="gender", type="string", example="male"),
     *             @OA\Property(property="province_id", type="string", example="11"),
     *             @OA\Property(property="city_id", type="string", example="1101"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Profile updated successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", example="1990-05-15"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="province_id", type="string", example="11"),
     *                 @OA\Property(property="city_id", type="string", example="1101"),
     *                 @OA\Property(property="bio", type="string", example="Experienced software developer"),
     *                 @OA\Property(property="file_cv", type="string", example="profile.jpg"),
     *                 @OA\Property(property="file_cover_letter", type="string", example="resume.pdf"),
     *                 @OA\Property(property="file_profile_image", type="boolean", example=true),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="gender", type="array",
     *                     @OA\Items(type="string", example="The selected gender is invalid.")
     *                 ),
     *                 @OA\Property(property="date_of_birth", type="array",
     *                     @OA\Items(type="string", example="The date of birth is not a valid date.")
     *                 )
     *             ),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update profile",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to update profile"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function update_profile(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date',
                'gender' => 'required|in:male,female',
                'province_id' => 'required|string',
                'city_id' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'data' => null
                ], 422);
            }

            $updatedUser = $this->profileService->updateProfile($user, $validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Profile updated successfully',
                'data' => $updatedUser
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update profile',
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/applicant/profile",
     *     tags={"Applicant"},
     *     summary="Get applicant profile",
     *     description="Retrieve the authenticated applicant's profile information.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Profile retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Profile retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="first_name", type="string", example="John"),
     *                 @OA\Property(property="last_name", type="string", example="Doe"),
     *                 @OA\Property(property="date_of_birth", type="string", format="date", example="1990-05-15"),
     *                 @OA\Property(property="gender", type="string", example="male"),
     *                 @OA\Property(property="province_id", type="string", example="11"),
     *                 @OA\Property(property="city_id", type="string", example="1101"),
     *                 @OA\Property(property="phone", type="string", example="+6281234567890"),
     *                 @OA\Property(property="bio", type="string", example="Experienced software developer"),
     *                 @OA\Property(property="file_cv", type="string", example="profile.jpg"),
     *                 @OA\Property(property="file_cover_letter", type="string", example="resume.pdf"),
     *                 @OA\Property(property="file_profile_image", type="boolean", example=true),
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
    public function get_profile()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $profile = $this->profileService->getProfile($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile retrieved successfully',
                'data' => $profile
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve profile',
                'data' => null
            ], 500);
        }
    }
}
