<?php

namespace App\Http\Controllers\api\Applicant;

use App\Http\Controllers\Controller;
use App\Models\JobMaster;
use App\Models\User;
use App\Models\UserBookmark;
use App\Models\JobBookmarks;
use Exception;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * @OA\Post(
     *     path="/applicant/activity/bookmark_job",
     *     tags={"Applicant Activity"},
     *     summary="Bookmark or unbookmark a job",
     *     description="Authenticated applicant bookmarks or unbookmarks a job by job_id. If already bookmarked, it will unbookmark.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"job_id"},
     *             @OA\Property(property="job_id", type="integer", example=1, description="The ID of the job to bookmark or unbookmark.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job bookmarked or unbookmarked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job bookmarked successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="job_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Job not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Job not found"),
     *             @OA\Property(property="data", type="object", example=null)
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
     *         description="Failed to bookmark job",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to bookmark job: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function bookmark_job(Request $request)
    {
        try {
            $userId = auth('sanctum')->id();
            $jobId = $request->job_id;

            $job = JobMaster::find($jobId);
            if (!$job) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Job not found',
                    'data' => null
                ], 404);
            }

            if (JobBookmarks::where('user_id', $userId)->where('job_id', $jobId)->exists()) {
                $bookmark = JobBookmarks::where('user_id', $userId)->where('job_id', $jobId)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Job unbookmarked successfully',
                    'data' => $bookmark
                ], 200);
            }

            $bookmark = JobBookmarks::create([
                'user_id' => $userId,
                'job_id' => $jobId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Job bookmarked successfully',
                'data' => $bookmark
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to bookmark job: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/applicant/activity/bookmark_company",
     *     tags={"Applicant Activity"},
     *     summary="Bookmark or unbookmark a company",
     *     description="Authenticated applicant bookmarks or unbookmarks a company by company_id. If already bookmarked, it will unbookmark.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"company_id"},
     *             @OA\Property(property="company_id", type="integer", example=1, description="The ID of the company to bookmark or unbookmark.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Company bookmarked or unbookmarked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Company bookmarked successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="bookmarked_user_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Company not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Company not found"),
     *             @OA\Property(property="data", type="object", example=null)
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
     *         description="Failed to bookmark company",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to bookmark company: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function bookmark_company(Request $request)
    {
        try {
            $userId = auth('sanctum')->id();
            $companyBookmarkedId = $request->company_id;

            $company = User::find($companyBookmarkedId);
            if (!$company) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Company not found',
                    'data' => null
                ], 404);
            }

            if (UserBookmark::where('user_id', $userId)->where('bookmarked_user_id', $companyBookmarkedId)->exists()) {
                $bookmark = UserBookmark::where('user_id', $userId)->where('bookmarked_user_id', $companyBookmarkedId)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Company unbookmarked successfully',
                    'data' => $bookmark
                ], 200);
            }

            $bookmark = UserBookmark::create([ 
                'user_id' => $userId,
                'bookmarked_user_id' => $companyBookmarkedId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([   
                'status' => 'success',
                'message' => 'Company bookmarked successfully',
                'data' => $bookmark
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to bookmark company: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/applicant/activity/saved/job",
     *     tags={"Applicant Activity"},
     *     summary="Get all bookmarked jobs",
     *     description="Get all jobs that have been bookmarked by the authenticated applicant.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Bookmarked jobs retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Bookmark job fetched successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="position", type="string", example="Software Engineer"),
     *                     @OA\Property(property="description", type="string", example="We are looking for a skilled software engineer..."),
     *                     @OA\Property(property="qualification", type="string", example="Bachelor's degree in Computer Science..."),
     *                     @OA\Property(property="image", type="string", example="jobs/123_image.jpg"),
     *                     @OA\Property(property="status", type="string", example="active"),
     *                     @OA\Property(property="apply_count", type="integer", example=15),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     @OA\Property(property="employment_type", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Full-time")
     *                     ),
     *                     @OA\Property(property="experience", type="object",
     *                         @OA\Property(property="id", type="integer", example=2),
     *                         @OA\Property(property="name", type="string", example="2-5 years")
     *                     ),
     *                     @OA\Property(property="education", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Bachelor's Degree")
     *                     ),
     *                     @OA\Property(property="expected_salary", type="object",
     *                         @OA\Property(property="id", type="integer", example=3),
     *                         @OA\Property(property="name", type="string", example="5-10 million")
     *                     ),
     *                     @OA\Property(property="province", type="object",
     *                         @OA\Property(property="id", type="integer", example=31),
     *                         @OA\Property(property="name", type="string", example="DKI Jakarta")
     *                     ),
     *                     @OA\Property(property="city", type="object",
     *                         @OA\Property(property="id", type="integer", example=3171),
     *                         @OA\Property(property="name", type="string", example="Jakarta Selatan")
     *                     ),
     *                     @OA\Property(property="user", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="name", type="string", example="Tech Company Inc"),
     *                         @OA\Property(property="email", type="string", example="hr@techcompany.com"),
     *                         @OA\Property(property="profile_company", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="company_name", type="string", example="Tech Company Inc"),
     *                             @OA\Property(property="company_description", type="string", example="Leading technology company...")
     *                         )
     *                     )
     *                 )
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
     *         description="Failed to get bookmarked jobs",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to get bookmark job: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function get_bookmark_job(Request $request)
    {
        try {
            $userId = auth('sanctum')->id();
            $bookmark = JobBookmarks::where('user_id', $userId)->get();
            $jobs = JobMaster::query()
                ->withCount('apply')
                ->with('employmentType', 'experience', 'expectedSalary', 'education', 'province', 'city', 'user', 'user.profileCompany')
                ->whereIn('id', $bookmark->pluck('job_id'))
                ->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark job fetched successfully',
                'data' => $jobs
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get bookmark job: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/applicant/activity/saved/company",
     *     tags={"Applicant Activity"},
     *     summary="Get all bookmarked companies",
     *     description="Get all companies that have been bookmarked by the authenticated applicant.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Bookmarked companies retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Bookmark company fetched successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Tech Company Inc"),
     *                     @OA\Property(property="email", type="string", example="hr@techcompany.com"),
     *                     @OA\Property(property="type", type="string", example="recruiter"),
     *                     @OA\Property(property="exp", type="integer", example=1500),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     @OA\Property(property="profile_company", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="company_name", type="string", example="Tech Company Inc"),
     *                         @OA\Property(property="company_description", type="string", example="Leading technology company specializing in software development..."),
     *                         @OA\Property(property="company_website", type="string", example="https://techcompany.com"),
     *                         @OA\Property(property="company_size", type="string", example="50-100 employees"),
     *                         @OA\Property(property="industry", type="string", example="Technology"),
     *                         @OA\Property(property="province_id", type="string", example="31"),
     *                         @OA\Property(property="city_id", type="string", example="3171"),
     *                         @OA\Property(property="company_logo", type="string", example="company_logos/logo_1.jpg"),
     *                         @OA\Property(property="is_active", type="boolean", example=true),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time")
     *                     )
     *                 )
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
     *         description="Failed to get bookmarked companies",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to get bookmark company: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function get_bookmark_company(Request $request)
    {
        try {
            $userId = auth('sanctum')->id();
            $bookmark = UserBookmark::where('user_id', $userId)->get();
            $companies = User::query()
                ->with('profileCompany')
                ->whereIn('id', $bookmark->pluck('bookmarked_user_id'))
                ->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark company fetched successfully',
                'data' => $companies
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get bookmark company: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
