<?php

namespace App\Http\Controllers\api\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JobService;
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
     * @OA\POST(
     *     path="/recruiter/jobs/create",
     *     tags={"Reqruiter Jobs"},
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
     *     tags={"Reqruiter Jobs"},
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

    /**
     * @OA\GET(
     *     path="/recruiter/jobs/get-by-id",
     *     tags={"Reqruiter Jobs"},
     *     summary="Get job by id",
     *     description="Get job by id.",
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
     *         description="Job retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Job retrieved successfully"),
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
     *         description="Job retrieved failed",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Job retrieved failed"),
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
     *     tags={"Reqruiter Jobs"},
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
     *     tags={"Reqruiter Jobs"},
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
     *     tags={"Reqruiter Jobs"},
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
     *     tags={"Reqruiter Jobs"},
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
