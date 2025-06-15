<?php

namespace App\Http\Controllers\api\Jobs;

use App\Http\Controllers\Controller;
use App\Services\Job\JobService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function list_job_reqruiter() {
        try {
            $user = Auth::guard('sanctum')->user();
            $type = $user->type;
            $user_id = $user->id;
            $list_job = $this->jobService->get_list_job($user_id, $type);

            return response()->json([
                'message' => 'success',
                'data' => $list_job
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function list_job_applicant() {
        try {
            $user = Auth::guard('sanctum')->user();
            $type = $user->type;
            $user_id = $user->id;
            $list_job = $this->jobService->get_list_job($user_id, $type);

            return response()->json([
                'message' => 'success',
                'data' => $list_job
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function detail_job($id) {
        try {
            $auth = Auth::guard('sanctum')->user();
            $type = $auth->type;
            $user_id = $auth->id;
            $detail_job = $this->jobService->get_detail_job($id, $type, $user_id);

            return response()->json([
                'message' => 'success',
                'data' => $detail_job
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function bookmark_job(Request $request) {
        try {
            $user_id = Auth::guard('sanctum')->user()->id;
            $job = $this->jobService->bookmark_job($request->job_id, $user_id);

            return response()->json([
                'message' => 'success',
                'data' => $job
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function apply_job(Request $request) {
        try {
            $user_id = Auth::guard('sanctum')->user()->id;
            $job = $this->jobService->apply_job($request->job_id, $user_id);

            return response()->json([
                'message' => 'success',
                'data' => $job
            ]);
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }

    public function add_job(Request $request) {
        try {
            $validated = Validator::make(
                $request->all(),
                [
                    "title" => "required",
                    "description" => "required",
                    "post_by" => "required",
                    "city" => "required|string|max:255",
                    "country" => "required|string|max:255",
                    "deadline" => "required|date",
                    "job_type" => "required|in:fart time,full time,daily,internship,freelance",
                    "position" => "required|string",
                    "min_salary" => "sometimes",
                    "max_salary" => "sometimes",
                    "min_experience" => "sometimes",
                    "max_experience" => "sometimes",
                    "job_requirement" => "sometimes|array",
                ]
            );

            if ($validated->fails()) {
                return response()->json([
                    "status" => "error",
                    "message" => "Validation Failed",
                    "errors" => $validated->errors()
                ], 422);
            } else {
                $user_id = Auth::guard('sanctum')->user()->id;
                $job = $this->jobService->create_job($validated->getData(), $user_id);

                return response()->json([
                    'message' => 'success',
                    'data' => $job
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}
