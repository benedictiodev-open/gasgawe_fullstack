<?php

namespace App\Http\Controllers\api\Jobs;

use App\Http\Controllers\Controller;
use App\Services\Job\JobService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
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
}
