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
     *     tags={"Applicant Profile"},
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
     *     tags={"Applicant Profile"},
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

    /**
     * @OA\Post(
     *     path="/applicant/profile/complete_profile",
     *     tags={"Applicant Profile"},
     *     summary="Update applicant advanced profile",
     *     description="Update the authenticated applicant's advanced profile information including bio, file uploads, career history, and education history.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="bio", type="string", example="Experienced software developer with 5+ years in web development"),
     *                 @OA\Property(property="file_cv", type="file", format="binary", description="CV/Resume file (PDF, max 2MB)"),
     *                 @OA\Property(property="file_cover_letter", type="file", format="binary", description="Cover letter file (PDF, max 2MB)"),
     *                 @OA\Property(property="career_history", type="array", 
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="company_name", type="string", example="Tech Corp"),
     *                         @OA\Property(property="position", type="string", example="Senior Developer"),
     *                         @OA\Property(property="start_date", type="string", format="date", example="2020-01-01"),
     *                         @OA\Property(property="end_date", type="string", format="date", example="2023-12-31"),
     *                         @OA\Property(property="description", type="string", example="Led development team of 5 developers"),
     *                         @OA\Property(property="skills", type="array", 
     *                             @OA\Items(type="integer", example=1),
     *                             description="Array of skill IDs"
     *                         ),
     *                         @OA\Property(property="employment_type_id", type="integer", example=1)
     *                     )
     *                 ),
     *                 @OA\Property(property="education", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="institution", type="string", example="University of Technology"),
     *                         @OA\Property(property="degree", type="string", example="Bachelor of Science"),
     *                         @OA\Property(property="field_of_study", type="string", example="Computer Science"),
     *                         @OA\Property(property="start_date", type="string", format="date", example="2016-09-01"),
     *                         @OA\Property(property="end_date", type="string", format="date", example="2020-06-30"),
     *                         @OA\Property(property="description", type="string", example="Focused on software engineering and web development"),
     *                         @OA\Property(property="grade", type="string", example="3.8/4.0")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Advanced profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Advanced profile updated successfully"),
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
     *                 @OA\Property(property="bio", type="string", example="Experienced software developer with 5+ years in web development"),
     *                 @OA\Property(property="file_cv", type="string", example="applicant_files/cv/cv_1_1234567890.pdf"),
     *                 @OA\Property(property="file_cover_letter", type="string", example="applicant_files/cover_letter/cover_letter_1_1234567890.pdf"),
     *                 @OA\Property(property="is_active", type="boolean", example=true),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time"),
     *                 @OA\Property(property="career_history", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="company_name", type="string", example="Tech Corp"),
     *                         @OA\Property(property="position", type="string", example="Senior Developer"),
     *                         @OA\Property(property="start_date", type="string", format="date", example="2020-01-01"),
     *                         @OA\Property(property="end_date", type="string", format="date", example="2023-12-31"),
     *                         @OA\Property(property="description", type="string", example="Led development team of 5 developers"),
     *                         @OA\Property(property="employment_type_id", type="integer", example=1),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                         @OA\Property(property="skills", type="array",
     *                             @OA\Items(type="object",
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="PHP"),
     *                                 @OA\Property(property="description", type="string", example="PHP programming language")
     *                             )
     *                         ),
     *                         @OA\Property(property="employment_type", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Fulltime"),
     *                             @OA\Property(property="description", type="string", example="Full-time employment")
     *                         )
     *                     )
     *                 ),
     *                 @OA\Property(property="education_history", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="institution", type="string", example="University of Technology"),
     *                         @OA\Property(property="degree", type="string", example="Bachelor of Science"),
     *                         @OA\Property(property="field_of_study", type="string", example="Computer Science"),
     *                         @OA\Property(property="start_date", type="string", format="date", example="2016-09-01"),
     *                         @OA\Property(property="end_date", type="string", format="date", example="2020-06-30"),
     *                         @OA\Property(property="description", type="string", example="Focused on software engineering and web development"),
     *                         @OA\Property(property="grade", type="string", example="3.8/4.0"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time")
     *                     )
     *                 )
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
     *                 @OA\Property(property="file_cv", type="array",
     *                     @OA\Items(type="string", example="The file cv must be a file of type: pdf."),
     *                     @OA\Items(type="string", example="The file cv may not be greater than 2048 kilobytes.")
     *                 ),
     *                 @OA\Property(property="file_cover_letter", type="array",
     *                     @OA\Items(type="string", example="The file cover letter may not be greater than 2048 kilobytes.")
     *                 ),
     *                 @OA\Property(property="career_history.0.company_name", type="array",
     *                     @OA\Items(type="string", example="The career history.0.company name field is required.")
     *                 ),
     *                 @OA\Property(property="career_history.0.skills.0", type="array",
     *                     @OA\Items(type="string", example="The selected career history.0.skills.0 is invalid.")
     *                 ),
     *                 @OA\Property(property="education.0.institution", type="array",
     *                     @OA\Items(type="string", example="The education.0.institution field is required.")
     *                 )
     *             ),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update advanced profile",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to update advanced profile"),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function update_advance_profile(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();

            $validator = Validator::make($request->all(), [
                'bio' => 'sometimes|string|max:1000',
                'file_cv' => 'nullable|file|mimes:pdf|max:2048',
                'file_cover_letter' => 'nullable|file|mimes:pdf|max:2048',
                'career_history' => 'sometimes',
                // 'career_history.*.company_name' => 'sometimes|string|max:255',
                // 'career_history.*.position' => 'sometimes|string|max:255',
                // 'career_history.*.start_date' => 'sometimes|date',
                // 'career_history.*.end_date' => 'sometimes|date',
                // 'career_history.*.description' => 'sometimes|string|max:1000',
                // 'career_history.*.skills' => 'sometimes|array',
                // 'career_history.*.skills.*' => 'sometimes|exists:skills,id',
                // 'career_history.*.employment_type_id' => 'sometimes|exists:employment_types,id',
                'education' => 'sometimes',
                // 'education.*.institution' => 'sometimes|string|max:255',
                // 'education.*.degree' => 'sometimes|string|max:255',
                // 'education.*.field_of_study' => 'sometimes|string|max:255',
                // 'education.*.start_date' => 'sometimes|date',
                // 'education.*.end_date' => 'sometimes|date',
                // 'education.*.description' => 'sometimes|string|max:1000',
                // 'education.*.grade' => 'sometimes|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                    'data' => null
                ], 422);
            }

            $updatedProfile = $this->profileService->updateAdvancedProfile($user, $validator->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Advanced profile updated successfully',
                'data' => $updatedProfile
            ], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update advanced profile: ' . $th->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update advanced profile',
                'data' => null
            ], 500);
        }
    }
}
