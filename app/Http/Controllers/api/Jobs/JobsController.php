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

    public function list_job() {
        try {
            
        } catch (Exception $error) {
            return response()->json([
                'message' => $error->getMessage(),
            ], 500);
        }
    }
}
