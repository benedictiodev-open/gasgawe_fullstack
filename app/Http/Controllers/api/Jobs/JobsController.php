<?php

namespace App\Http\Controllers\api\Jobs;

/**
 * @OA\Info(
 *     title="Gas Gawe",
 *     version="1.0.0",
 *     description="Documentation api for mobile apps"
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 */

use App\Http\Controllers\Controller;
use App\Services\Job\JobService;
use Exception;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/recruitment/jobs",
     *     tags={"Jobs"},
     *     summary="Ambil daftar job",
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data user"
     *     )
     * )
     */

    private $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function list_job() {
        try {
            $list_job = $this->jobService->get_list_job();

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
}
