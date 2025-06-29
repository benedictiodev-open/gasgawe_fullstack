<?php

namespace App\Http\Controllers\api\Applicant;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobMaster;
use App\Models\JobUsersApply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * @OA\Get(
     *     path="/applicant/jobs/ontrending",
     *     tags={"Applicant Jobs"},
     *     summary="Get trending recruiters",
     *     description="Get list of trending recruiters ordered by experience in descending order",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Trending recruiters retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Trending recruiters retrieved successfully"),
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john@example.com"),
     *                     @OA\Property(property="type", type="string", example="recruiter"),
     *                     @OA\Property(property="exp", type="integer", example=1500),
     *                     @OA\Property(property="total_jobs", type="integer", example=25),
     *                     @OA\Property(property="total_applications", type="integer", example=150),
     *                     @OA\Property(property="job_types", type="array", 
     *                         @OA\Items(type="string", example="Fulltime")
     *                     ),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
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
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function on_trending_jobs()
    {
        try {
            // Get recruiters ordered by exp desc
            $recruiters = DB::table('users')
                ->select([
                    'users.id',
                    'user_profile_companies.company_name',
                    'indonesia_provinces.name as province_name',
                    'indonesia_cities.name as city_name',
                    'users.exp',
                    DB::raw('COUNT(DISTINCT job_masters.id) as total_jobs'),
                    DB::raw('GROUP_CONCAT(DISTINCT employment_types.name) as job_types')
                ])
                ->leftJoin('user_profile_companies', 'users.id', '=', 'user_profile_companies.user_id')
                ->leftJoin('job_masters', 'users.id', '=', 'job_masters.created_by')
                ->leftJoin('employment_types', 'job_masters.employment_type_id', '=', 'employment_types.id')
                ->leftJoin('indonesia_provinces', 'user_profile_companies.province_id', '=', 'indonesia_provinces.id')
                ->leftJoin('indonesia_cities', 'user_profile_companies.city_id', '=', 'indonesia_cities.id')
                ->where('users.type', 'recruiter')
                ->groupBy('users.id', 'user_profile_companies.company_name', 'indonesia_provinces.name', 'indonesia_cities.name', 'users.exp')
                ->orderByDesc('users.exp')
                ->limit(10)
                ->get();

            // Process the results to convert job_types string to array
            $recruiters = $recruiters->map(function ($recruiter) {
                if ($recruiter->job_types) {
                    $recruiter->job_types = explode(',', $recruiter->job_types);
                } else {
                    $recruiter->job_types = [];
                }
                return $recruiter;
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Trending recruiters retrieved successfully',
                'data' => $recruiters
            ], 200);

        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve trending recruiters: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
