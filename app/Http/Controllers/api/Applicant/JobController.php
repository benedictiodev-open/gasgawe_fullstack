<?php

namespace App\Http\Controllers\api\Applicant;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\JobMaster;
use App\Models\JobUsersApply;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Skill;
use App\Models\Province;
use App\Models\City;
use App\Services\Job\JobService;

class JobController extends Controller
{
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * @OA\Get(
     *     path="/applicant/jobs/get-job-by-id",
     *     tags={"Applicant Jobs"},
     *     summary="Get job by id",
     *     description="Get job by id.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="job_id",
     *         in="query",
     *         required=true,
     *         description="Job id"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job retrieved successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *         )
     *      )
     * )
     */
    public function get_job_by_id(Request $request)
    {
        try {
            $job = $this->jobService->get_job_by_id($request->job_id);
            return response()->json([
                'status' => 'success',
                'message' => 'Get data job Successfully',
                'data' => $job
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get data job: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

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
                ->where('job_masters.status', 'active')
                ->having('total_jobs', '>', 0)
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

    /**
     * @OA\Get(
     *     path="/applicant/jobs/filter-option",
     *     tags={"Applicant Jobs"},
     *     summary="Filter jobs",
     *     description="Filter jobs by search",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         required=false,
     *         description="Search for jobs by location (province or city), or skill"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jobs filtered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Jobs filtered successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="job_roles", type="array",
     *                     @OA\Items(type="string", example="Software Engineer")
     *                 ),
     *                 @OA\Property(property="job_location_provinces", type="array",
     *                     @OA\Items(type="string", example="Jakarta")
     *                 ),
     *                 @OA\Property(property="job_location_cities", type="array",
     *                     @OA\Items(type="string", example="Jakarta")
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
    public function filter_jobs(Request $request)
    {
        try {
            $search = $request->search;

            $skills = Skill::where('name', 'like', '%' . $search . '%')->get();
            $provinces = Province::where('name', 'like', '%' . $search . '%')->get();
            $cities = City::where('name', 'like', '%' . $search . '%')->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Jobs filtered successfully',
                'data' => [
                    'job_roles' => $skills,
                    'job_location_provinces' => $provinces,
                    'job_location_cities' => $cities,
                ]
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to filter jobs: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/applicant/jobs/recommendations",
     *     tags={"Applicant Jobs"},
     *     summary="Get all jobs with pagination and filters",
     *     description="Get all active jobs with simple pagination and optional filters for applicant",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Number of jobs per page (default: 10)",
     *         @OA\Schema(type="integer", default=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page number (default: 1)",
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Parameter(
     *         name="skills",
     *         in="query",
     *         required=false,
     *         description="Filter by skill IDs (comma-separated or array)",
     *         @OA\Schema(type="string", example="1,2,3")
     *     ),
     *     @OA\Parameter(
     *         name="province_id",
     *         in="query",
     *         required=false,
     *         description="Filter by province ID",
     *         @OA\Schema(type="integer", example=31)
     *     ),
     *     @OA\Parameter(
     *         name="city_id",
     *         in="query",
     *         required=false,
     *         description="Filter by city ID",
     *         @OA\Schema(type="integer", example=3171)
     *     ),
     *     @OA\Parameter(
     *         name="employment_type_id",
     *         in="query",
     *         required=false,
     *         description="Filter by employment type ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="expected_salary_id",
     *         in="query",
     *         required=false,
     *         description="Filter by expected salary ID",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="time_filter",
     *         in="query",
     *         required=false,
     *         description="Filter by time period (most_recent, this_week, this_month, any_time)",
     *         @OA\Schema(type="string", example="most_recent")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jobs retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Jobs retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="data", type="array",
     *                     @OA\Items(type="object",
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="position", type="string", example="Software Engineer"),
     *                         @OA\Property(property="description", type="string", example="We are looking for a skilled software engineer..."),
     *                         @OA\Property(property="qualification", type="string", example="Bachelor's degree in Computer Science..."),
     *                         @OA\Property(property="image", type="string", example="jobs/123_image.jpg"),
     *                         @OA\Property(property="status", type="string", example="active"),
     *                         @OA\Property(property="created_at", type="string", format="date-time"),
     *                         @OA\Property(property="updated_at", type="string", format="date-time"),
     *                         @OA\Property(property="employment_type", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Full-time")
     *                         ),
     *                         @OA\Property(property="experience", type="object",
     *                             @OA\Property(property="id", type="integer", example=2),
     *                             @OA\Property(property="name", type="string", example="2-5 years")
     *                         ),
     *                         @OA\Property(property="education", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Bachelor's Degree")
     *                         ),
     *                         @OA\Property(property="expected_salary", type="object",
     *                             @OA\Property(property="id", type="integer", example=3),
     *                             @OA\Property(property="name", type="string", example="5-10 million")
     *                         ),
     *                         @OA\Property(property="province", type="object",
     *                             @OA\Property(property="id", type="integer", example=31),
     *                             @OA\Property(property="name", type="string", example="DKI Jakarta")
     *                         ),
     *                         @OA\Property(property="city", type="object",
     *                             @OA\Property(property="id", type="integer", example=3171),
     *                             @OA\Property(property="name", type="string", example="Jakarta Selatan")
     *                         ),
     *                         @OA\Property(property="skills", type="array",
     *                             @OA\Items(type="object",
     *                                 @OA\Property(property="id", type="integer", example=1),
     *                                 @OA\Property(property="name", type="string", example="PHP"),
     *                                 @OA\Property(property="skill_group", type="object",
     *                                     @OA\Property(property="id", type="integer", example=1),
     *                                     @OA\Property(property="name", type="string", example="Programming Languages")
     *                                 )
     *                             )
     *                         ),
     *                         @OA\Property(property="user", type="object",
     *                             @OA\Property(property="id", type="integer", example=1),
     *                             @OA\Property(property="name", type="string", example="Tech Company Inc"),
     *                             @OA\Property(property="email", type="string", example="hr@techcompany.com")
     *                         ),
     *                         @OA\Property(property="bookmark", type="array", @OA\Items(type="object")),
     *                         @OA\Property(property="apply", type="array", @OA\Items(type="object"))
     *                     )
     *                 ),
     *                 @OA\Property(property="first_page_url", type="string", example="http://localhost/api/applicant/jobs/recommendations?page=1"),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="next_page_url", type="string", example="http://localhost/api/applicant/jobs/recommendations?page=2"),
     *                 @OA\Property(property="path", type="string", example="http://localhost/api/applicant/jobs/recommendations"),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="prev_page_url", type="string", example=null),
     *                 @OA\Property(property="to", type="integer", example=10)
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
    public function recommendation_job(Request $request)
    {
        try {
            $userId = auth('sanctum')->user()->id;
            $perPage = $request->get('per_page', 10);

            // Build filters array
            $filters = [];

            if ($request->has('skills')) {
                $filters['skills'] = $request->get('skills');
            }

            if ($request->has('province_id')) {
                $filters['province_id'] = $request->get('province_id');
            }

            if ($request->has('city_id')) {
                $filters['city_id'] = $request->get('city_id');
            }

            if ($request->has('employment_type_id')) {
                $filters['employment_type_id'] = $request->get('employment_type_id');
            }

            if ($request->has('expected_salary_id')) {
                $filters['expected_salary_id'] = $request->get('expected_salary_id');
            }

            if ($request->has('time_filter')) {
                $filters['time_filter'] = $request->get('time_filter');
            }

            // Get all jobs with pagination and filters
            $jobs = $this->jobService->getJobRecommendations($userId, $perPage, $filters);

            return response()->json([
                'status' => 'success',
                'message' => 'Jobs retrieved successfully',
                'data' => $jobs
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get jobs: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/applicant/jobs/search",
     *     tags={"Applicant Jobs"},
     *     summary="Search jobs",
     *     description="Search jobs by position, company name, or skill",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search for jobs by position, company name, or skill"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Jobs retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Jobs retrieved successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
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
     * )
     */
    public function search_job(Request $request)
    {
        try {
            $jobs = JobMaster::with('user', 'user.profileCompany', 'skills', 'province', 'city', 'employmentType', 'experience', 'education', 'expectedSalary')
                ->where('position', 'like', '%' . $request->search . '%')
                ->orWhereHas('user.profileCompany', function ($query) use ($request) {
                    $query->where('company_name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('skills', function ($query) use ($request) {
                    $query->whereHas('skill', function($query_skill) use ($request) {
                        $query_skill->where('name', 'like', '%' . $request->search . '%');
                    });
                })
                ->get();
            
            return response()->json([
                'status' => 'success',
                'message' => 'Search data job successfully',
                'data' => $jobs
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to search jobs: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/applicant/jobs/apply",
     *     tags={"Applicant Jobs"},
     *     summary="Apply for a job",
     *     description="Authenticated applicant applies for a job by job_id.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"job_id"},
     *             @OA\Property(property="job_id", type="integer", example=1, description="The ID of the job to apply for.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job applied successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job applied successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="position", type="string", example="Software Engineer"),
     *                 @OA\Property(property="status", type="string", example="active"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Job already applied",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Job already applied"),
     *             @OA\Property(property="data", type="object", example=null)
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
     *         description="Failed to apply job",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Failed to apply job: ..."),
     *             @OA\Property(property="data", type="object", example=null)
     *         )
     *     )
     * )
     */
    public function apply_job(Request $request)
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

            if ($job->apply()->where('user_id', $userId)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Job already applied',
                    'data' => null
                ], 400);
            }

            $job->apply()->create([
                'job_id' => $jobId,
                'user_id' => $userId,
                'status' => 'Applied',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Job applied successfully',
                'data' => $job
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to apply job: ' . $error->getMessage(),
                'data' => null
            ], 500);
        }
    }
}
