<?php

namespace App\Http\Controllers\api\Recruiter;

use App\Http\Controllers\Controller;
use App\Models\JobMaster;
use App\Models\User;
use App\Models\UserBookmark;
use App\Models\Video;
use App\Models\VideoBookmark;
use App\Services\Job\JobService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    use ResponseTrait;
    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * 
     * @OA\Post(
     *     path="/recruiter/activity/bookmark-video",
     *     tags={"Recruiter Activity"},
     *     summary="Bookmark or unbookmark a video",
     *     description="Authenticated applicant bookmarks or unbookmarks a video by video_id. If already bookmarked, it will unbookmark.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"video_id"},
     *             @OA\Property(property="video_id", type="integer", example=1, description="The ID of the video to bookmark or unbookmark.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Video bookmarked or unbookmarked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Video bookmarked successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=2),
     *                 @OA\Property(property="video_id", type="integer", example=1),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Video not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Video not found"),
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
     *         description="Failed to bookmark video",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to bookmark video: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function bookmarkVideo(Request $request)
    {
        try {
            $userId = auth('sanctum')->id();
            $videoId = $request->video_id;

            $video = Video::find($videoId);

            if (!$video) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Video not found',
                    'data' => null
                ], 404);
            }

            if (VideoBookmark::where('user_id', $userId)->where('video_id', $videoId)->exists()) {
                $bookmark = VideoBookmark::where('user_id', $userId)->where('video_id', $videoId)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Video unbookmarked successfully',
                    'data' => $bookmark
                ], 200);
            }

            $bookmark = VideoBookmark::create([
                'user_id' => $userId,
                'video_id' => $videoId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Video bookmarked successfully',
                'data' => $bookmark
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to bookmark video: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @SuppressWarnings(PHPMD.LongVariable)
     * 
     * @OA\Post(
     *     path="/recruiter/activity/bookmark-applicant",
     *     tags={"Recruiter Activity"},
     *     summary="Bookmark or unbookmark a applicant",
     *     description="Authenticated recruiter bookmarks or unbookmarks a applicant by applicant_id. If already bookmarked, it will unbookmark.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"applicant_id"},
     *             @OA\Property(property="applicant_id", type="integer", example=1, description="The ID of the applicant to bookmark or unbookmark.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Applicant bookmarked or unbookmarked successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Applicant bookmarked successfully"),
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
     *         description="Applicant not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Applicant not found"),
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
     *         description="Failed to bookmark applicant",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to bookmark applicant: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function bookmarkApplicant(Request $request)
    {
        try {
            $userId = auth('sanctum')->id();
            $applicantBookmarkedId = $request->applicant_id;

            $applicant = User::where('id', $applicantBookmarkedId)->where('type', 'applicant')->first();

            if (!$applicant) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Applicant not found',
                    'data' => null
                ], 404);
            }

            if (UserBookmark::where('user_id', $userId)->where('bookmarked_user_id', $applicantBookmarkedId)->exists()) {
                $bookmark = UserBookmark::where('user_id', $userId)->where('bookmarked_user_id', $applicantBookmarkedId)->delete();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Applicant unbookmarked successfully',
                    'data' => $bookmark
                ], 200);
            }

            $bookmark = UserBookmark::create([
                'user_id' => $userId,
                'bookmarked_user_id' => $applicantBookmarkedId,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Applicant bookmarked successfully',
                'data' => $bookmark
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to bookmark applicant: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * 
     * @OA\Get(
     *     path="/recruiter/activity/saved/video",
     *     tags={"Recruiter Activity"},
     *     summary="Get all bookmarked videos",
     *     description="Get all videos that have been bookmarked by the authenticated applicant.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Bookmarked videos retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Bookmark video fetched successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="position", type="string", example="Software Engineer"),
     *                     @OA\Property(property="description", type="string", example="We are looking for a skilled software engineer..."),
     *                     @OA\Property(property="qualification", type="string", example="Bachelor's degree in Computer Science..."),
     *                     @OA\Property(property="image", type="string", example="videos/123_image.jpg"),
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
     *         description="Failed to get bookmarked videos",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to get bookmark video: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function getBookmarkVideo()
    {
        try {
            $userId = auth('sanctum')->id();
            $bookmark = VideoBookmark::where('user_id', $userId)->get();

            $videos = Video::query()
                ->with('user.profileApplicant', 'user.experience', 'user.educationApplicant')
                ->whereIn('id', $bookmark->pluck('video_id'))
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark video fetched successfully',
                'data' => $videos
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get bookmark video: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * 
     * @OA\Get(
     *     path="/recruiter/activity/saved/applicant",
     *     tags={"Recruiter Activity"},
     *     summary="Get all bookmarked applicants",
     *     description="Get all applicants that have been bookmarked by the authenticated applicant.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Bookmarked applicants retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Bookmark applicant fetched successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Tech Applicant Inc"),
     *                     @OA\Property(property="email", type="string", example="hr@techapplicant.com"),
     *                     @OA\Property(property="type", type="string", example="recruiter"),
     *                     @OA\Property(property="exp", type="integer", example=1500),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time"),
     *                     @OA\Property(property="profile_applicant", type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="applicant_name", type="string", example="Tech Applicant Inc"),
     *                         @OA\Property(property="applicant_description", type="string", example="Leading technology applicant specializing in software development..."),
     *                         @OA\Property(property="applicant_website", type="string", example="https://techapplicant.com"),
     *                         @OA\Property(property="applicant_size", type="string", example="50-100 employees"),
     *                         @OA\Property(property="industry", type="string", example="Technology"),
     *                         @OA\Property(property="province_id", type="string", example="31"),
     *                         @OA\Property(property="city_id", type="string", example="3171"),
     *                         @OA\Property(property="applicant_logo", type="string", example="applicant_logos/logo_1.jpg"),
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
     *         description="Failed to get bookmarked applicants",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to get bookmark applicant: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */

    public function getBookmarkApplicant()
    {
        try {
            $userId = auth('sanctum')->id();
            $bookmark = UserBookmark::where('user_id', $userId)->get();
            $applicants = User::query()
                ->with(['profileApplicant', 'experience', 'educationApplicant'])
                ->whereIn('id', $bookmark->pluck('bookmarked_user_id'))
                ->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Bookmark applicant fetched successfully',
                'data' => $applicants
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get bookmark applicant: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
