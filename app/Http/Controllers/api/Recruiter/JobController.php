<?php

namespace App\Http\Controllers\api\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recruiter\GetActivityJobsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Job\JobService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;

class JobController extends Controller
{
    use ResponseTrait;
    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    /**
     * @OA\Get(
     *     path="/recruiter/jobs/activity",
     *     summary="Get job activity list",
     *     description="Get job activity list",
     *     tags={"Recruiter Jobs"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Filter jobs by status. Allowed: active, inactive",
     *         @OA\Schema(
     *             type="string",
     *             nullable=true,
     *             enum={"active", "inactive"},
     *             example="active"
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Jobs activity retrieved successfully",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="message", type="string", example="Jobs activity retrieved successfully"),
     *         @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="created_by", type="integer", example=1),
     *                 @OA\Property(property="description", type="string", example="Develop and maintain backend systems."),
     *                 @OA\Property(property="position", type="string", example="Software Engineer"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-12 11:52:21"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-12 11:52:21"),
     *                 @OA\Property(property="province_id", type="integer", example=11),
     *                 @OA\Property(property="city_id", type="integer", example=11),
     *                 @OA\Property(property="status", type="string", example="inactive"),
     *                 @OA\Property(property="employment_type_id", type="integer", example=2),
     *                 @OA\Property(property="experience_id", type="integer", example=3),
     *                 @OA\Property(property="education_id", type="integer", example=2),
     *                 @OA\Property(property="expected_salary_id", type="integer", example=4),
     *                 @OA\Property(property="qualification", type="string", example="Bachelor's Degree in Computer Science."),
     *                 @OA\Property(property="deleted_at", type="string", nullable=true, example=null),
     *                 @OA\Property(property="image", type="string", example="jobs/1_1752295941.jpg"),
     *                 @OA\Property(property="province_name", type="string", example="DKI JAKARTA"),
     *                 @OA\Property(property="city_name", type="string", example="KABUPATEN BIREUEN"),
     *                 @OA\Property(property="employment_type_name", type="string", example="Parttime"),
     *                 @OA\Property(property="expected_salary_name", type="string", example="Rp. 7.000.000 - Rp. 10.000.000"),
     *                 @OA\Property(property="education_name", type="string", example="Diploma (D1-D3)"),
     *                 @OA\Property(property="experience_name", type="string", example="1-3 Year")
     *             )
     *         )
     *     )
     * ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="status",
     *                     type="array",
     *                     @OA\Items(type="string", example="The selected status is invalid.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=503,
     *         description="Service Unavailable",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Service Unavailable")
     *         )
     *     )
     * )
     */

    public function activity(GetActivityJobsRequest $request)
    {
        try {
            $jobs = $this->jobService->getActivity($request->validated());

            return $this->successResponse($jobs, 'Jobs activity retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Service Unavailable');
        }
    }

    /**
     * @OA\POST(
     *     path="/recruiter/jobs/create",
     *     tags={"Recruiter Jobs"},
     *     summary="Create a new job",
     *     description="Create a new job.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={
     *                     "image", "position", "province_id", "city_id",
     *                     "employment_type_id", "experience_id", "expected_salary_id",
     *                     "education_id", "job_description", "qualification", "skills[]"
     *                 },
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="position", type="string", example="Software Engineer"),
     *                 @OA\Property(property="province_id", type="integer", example=11),
     *                 @OA\Property(property="city_id", type="integer", example=11),
     *                 @OA\Property(property="employment_type_id", type="integer", example=2),
     *                 @OA\Property(property="experience_id", type="integer", example=3),
     *                 @OA\Property(property="expected_salary_id", type="integer", example=4),
     *                 @OA\Property(property="education_id", type="integer", example=2),
     *                 @OA\Property(property="job_description", type="string", example="Develop and maintain backend systems."),
     *                 @OA\Property(property="qualification", type="string", example="Bachelor's Degree in Computer Science."),
     *                 @OA\Property(property="skills[]", type="array", @OA\Items(type="integer", example=1))
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Created a New Job Successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Created a New Job Successful"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Created a New Job Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Created a New Job Failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         )
     *     )
     * )
     */
    public function add_job(Request $request)
    {
        try {
            $validated = Validator::make(
                $request->all(),
                [
                    "image" => "required|image|mimes:jpeg,png,jpg|max:2048",
                    "position" => "required|string",
                    "province_id" => "required|exists:indonesia_provinces,id",
                    "city_id" => "required|exists:indonesia_cities,id",
                    "employment_type_id" => "required|exists:employment_types,id",
                    "experience_id" => "required|exists:experiences,id",
                    "expected_salary_id" => "required|exists:expected_salaries,id",
                    "education_id" => "required|exists:educations,id",
                    "job_description" => "required|string",
                    "qualification" => "required|string",
                    "skills" => "required|array"
                ]
            )->setAttributeNames([
                "province_id" => 'Province',
                "city_id" => 'City',
                "experience_id" => 'Experience',
                "expected_salary_id" => 'Expected Salary',
                "education_id" => 'Education',
                "job_description" => 'Job Description',
            ]);

            if ($validated->fails()) {
                return $this->errorResponse("Validation Failed", 422, $validated->errors());
            } else {
                $user_id = Auth::guard('sanctum')->user()->id;
                if ($request->file('image')) {
                    $uri = $this->jobService->handleFileUpload($request->file('image'), $user_id);
                    $validated->setValue('image', $uri);
                }
                $job = $this->jobService->store_job_master($validated->getData(), $user_id);

                return $this->successResponse($job);
            }
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/recruiter/jobs/update",
     *     tags={"Recruiter Jobs"},
     *     summary="Update a job",
     *     description="Update a job.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={
     *                     "image", "position", "province_id", "city_id",
     *                     "employment_type_id", "experience_id", "expected_salary_id",
     *                     "education_id", "job_description", "qualification", "skills[]", "job_id"
     *                 },
     *                 @OA\Property(property="image", type="string", format="binary", nullable=true),
     *                 @OA\Property(property="position", type="string", example="Software Engineer"),
     *                 @OA\Property(property="province_id", type="integer", example=11),
     *                 @OA\Property(property="city_id", type="integer", example=11),
     *                 @OA\Property(property="employment_type_id", type="integer", example=2),
     *                 @OA\Property(property="experience_id", type="integer", example=3),
     *                 @OA\Property(property="expected_salary_id", type="integer", example=4),
     *                 @OA\Property(property="education_id", type="integer", example=2),
     *                 @OA\Property(property="job_description", type="string", example="Develop and maintain backend systems."),
     *                 @OA\Property(property="qualification", type="string", example="Bachelor's Degree in Computer Science."),
     *                 @OA\Property(property="skills[]", type="array", @OA\Items(type="integer", example=1))
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job updated successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     * )
     */
    public function update_job(Request $request)
    {
        try {
            $validated = Validator::make(
                $request->all(),
                [
                    "image" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
                    "position" => "required|string",
                    "province_id" => "required|exists:indonesia_provinces,id",
                    "city_id" => "required|exists:indonesia_cities,id",
                    "employment_type_id" => "required|exists:employment_types,id",
                    "experience_id" => "required|exists:experiences,id",
                    "expected_salary_id" => "required|exists:expected_salaries,id",
                    "education_id" => "required|exists:educations,id",
                    "job_description" => "required|string",
                    "qualification" => "required|string",
                    "skills" => "required|array"
                ]
            )->setAttributeNames([
                "province_id" => 'Province',
                "city_id" => 'City',
                "experience_id" => 'Experience',
                "expected_salary_id" => 'Expected Salary',
                "education_id" => 'Education',
                "job_description" => 'Job Description',
            ]);

            if ($validated->fails()) {
                return $this->errorResponse("Validation Failed", 422, $validated->errors());
            } else {
                $user_id = Auth::guard('sanctum')->user()->id;
                if ($request->file('image')) {
                    $uri = $this->jobService->handleFileUpload($request->file('image'), $user_id);
                    $validated->setValue('image', $uri);
                }
                $job = $this->jobService->update_job_master($validated->getData(), $user_id);
                return $this->successResponse($job);
            }
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    public function search_applicant(Request $request)
    {
        try {
            $jobs = User::with('user', 'user.profileApplicant', 'skills', 'province', 'city', 'employmentType', 'experience', 'education', 'expectedSalary')
                ->orWhereHas('user.profileApplicant', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->orWhereHas('skills', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->get();
            return $this->successResponse($jobs);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/recruiter/jobs/get-by-id",
     *     tags={"Recruiter Jobs"},
     *     summary="Get job by id",
     *     description="Get job by id.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="job_id",
     *         in="query",
     *         required=true,
     *         description="Job ID",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job retrieved successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="data", nullable=true, example=null),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Job retrieved failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Job retrieved failed"),
     *             @OA\Property(property="data", nullable=true, example=null),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *             @OA\Property(property="data", nullable=true, example=null),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"))
     *         )
     *     )
     * )
     */
    public function get_job_by_id(Request $request)
    {
        try {
            $job = $this->jobService->get_job_by_id($request->job_id);
            return $this->successResponse($job);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/recruiter/jobs/get-applicant-by-job-id",
     *     tags={"Recruiter Jobs"},
     *     summary="Get applicant by job id",
     *     description="Get applicant by job id.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"job_id"},
     *                 @OA\Property(property="job_id", type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Applicants retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Applicants retrieved successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Applicants retrieved failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Applicants retrieved failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
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
     * )
     */
    public function get_applicant_by_job_id(Request $request)
    {
        try {
            $applicants = $this->jobService->get_applicant_by_job_id($request->job_id);
            return $this->successResponse($applicants);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\GET(
     *     path="/recruiter/jobs/get-applicant-detail-by-id",
     *     tags={"Recruiter Jobs"},
     *     summary="Get applicant detail by id",
     *     description="Get applicant detail by id.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"applicant_id"},
     *                 @OA\Property(property="applicant_id", type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Applicant detail retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Applicant detail retrieved successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Applicant detail retrieved failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Applicant detail retrieved failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
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
     * )
     */
    public function get_applicant_detail_by_id(Request $request)
    {
        try {
            $applicant = $this->jobService->get_applicant_detail_by_id($request->applicant_id);
            return $this->successResponse($applicant);
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/recruiter/jobs/update-applicant-apply-status",
     *     tags={"Recruiter Jobs"},
     *     summary="Update applicant apply status",
     *     description="Update applicant apply status.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"applicant_id", "status"},
     *                 @OA\Property(property="applicant_id", type="integer", example=1),
     *                 @OA\Property(property="status", type="string", example="Accepted"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Applicant apply status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Applicant apply status updated successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Applicant apply status updated failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Applicant apply status updated failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             )
     *         )
     *     )
     * )
     */
    public function update_applicant_apply_status(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'applicant_id' => 'required|exists:job_users_apply,id',
                'status' => 'required|in:Accepted,Rejected,On Review,Notice',
            ]);

            if ($validated->fails()) {
                return $this->errorResponse("Validation Failed", 422, $validated->errors());
            } else {
                $user_id = Auth::guard('sanctum')->user()->id;
                $applicant = $this->jobService->update_applicant_apply_status($request->applicant_id, $request->status, $user_id);
                return $this->successResponse($applicant);
            }
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/recruiter/jobs/update-status",
     *     tags={"Recruiter Jobs"},
     *     summary="Update job status",
     *     description="Update job status. (To active or inactive job)",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"job_id", "status"},
     *                 @OA\Property(property="job_id", type="integer", example=1),
     *                 @OA\Property(property="status", type="string", example="inactive"),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job status updated successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     * )
     */
    public function update_status_job(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'job_id' => 'required|exists:jobs,id',
                'status' => 'required|in:active,inactive',
            ]);

            if ($validated->fails()) {
                return $this->errorResponse("Validation Failed", 422, $validated->errors());
            } else {
                $user_id = Auth::guard('sanctum')->user()->id;
                $job = $this->jobService->update_status_job($validated->getData(), $user_id);
                return $this->successResponse($job);
            }
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }

    /**
     * @OA\POST(
     *     path="/recruiter/jobs/delete",
     *     tags={"Recruiter Jobs"},
     *     summary="Delete job",
     *     description="Delete job.",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 required={"job_id"},
     *                 @OA\Property(property="job_id", type="integer", example=1),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Job deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job deleted successfully"),
     *             @OA\Property(property="data", type="object"),
     *             @OA\Property(property="error", type="boolean"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Validation Failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Job deleted failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Job deleted failed"),
     *             @OA\Property(property="data", type="null", nullable="true", example="null"),
     *             @OA\Property(property="error", type="boolean"),
     *             @OA\Property(property="errors", type="array",  @OA\Items(type="string")),
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
     * )
     */
    public function delete_job(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                'job_id' => 'required|exists:jobs,id',
            ]);

            if ($validated->fails()) {
                return $this->errorResponse("Validation Failed", 422, $validated->errors());
            } else {
                $user_id = Auth::guard('sanctum')->user()->id;
                $job = $this->jobService->delete_job($validated->getData(), $user_id);
                return $this->successResponse($job);
            }
        } catch (Exception $error) {
            return $this->errorResponse($error->getMessage());
        }
    }
}
