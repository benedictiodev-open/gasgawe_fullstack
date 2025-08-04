<?php

namespace App\Http\Controllers\api\Video;

use App\Http\Controllers\Controller;
use App\Http\Requests\Video\StoreVideoRequest;
use App\Models\Video;
use App\Services\Video\VideoService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    use ResponseTrait;

    protected $videoService;

    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/video",
     *     summary="Upload a video file",
     *     tags={"Video"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"file"},
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="Video file (mp4, mov, avi), max 100MB"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Video uploaded successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Upload successful"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="path", type="string", example="/storage/files/video/abc123.mp4"),
     *                 @OA\Property(property="thumbnail_path", type="string", example="/storage/files/thumbnails/abc123.jpg"),
     *                 @OA\Property(property="duration", type="number", format="integer", example=1255, description="Duration of the video in seconds"),
     *                 @OA\Property(property="size", type="integer", example=10485760, description="File size in bytes")
     *              )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="file",
     *                     type="array",
     *                     @OA\Items(type="string", example="The file field is required.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreVideoRequest $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            $video = $this->videoService->store($user, $request->validated());

            if (!$video) {
                return $this->errorResponse('Service Unavailable', 503);
            }

            return $this->successResponse($video, 'Video uploaded successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Service Unavailable', 503);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        //
    }
}
