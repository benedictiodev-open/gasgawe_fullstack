<?php

namespace App\Http\Controllers\api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\GetApplicantNotificationRequest;
use App\Services\Notification\NotificationService;
use App\Traits\ResponseTrait;

class NotificationController extends Controller
{
    use ResponseTrait;
    private $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * @OA\Get(
     *     path="/applicant/notification",
     *     summary="Get Applicant Notification",
     *     description="Get Applicant Notification",
     *     tags={"Notification"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         required=false,
     *         description="Filter jobs by status. Allowed: Reject,Accept,Notice,Review",
     *         @OA\Schema(
     *             type="string",
     *             nullable=true,
     *             enum={"Reject", "Accept", "Review", "Notice"},
     *             example="Review"
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="Notification retrieved successfully",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="message", type="string", example="Notification retrieved successfully"),
     *         @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Interview Invitation: PT. One Two Three - Software Engineer"),
     *                 @OA\Property(property="description", type="string", example="You have been invited for an interview by PT. One Two Three for the Software Engineer position. Please check your schedule and confirm your availability."),
     *                 @OA\Property(property="is_read", type="boolean", example=false),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-12 11:52:21"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-12 11:52:21"),
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
    public function applicant(GetApplicantNotificationRequest $request)
    {
        try {
            $notification = $this->notificationService->getApplicantNotification($request->validated());

            return $this->successResponse($notification, 'Notification retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Service Unavailable');
        }
    }

    /**
     * @OA\Get(
     *     path="/recruiter/notification",
     *     summary="Get Recruiter Notification",
     *     description="Get Recruiter Notification",
     *     tags={"Notification"},
     *     security={{"bearerAuth":{}}},
     * @OA\Response(
     *     response=200,
     *     description="Notification retrieved successfully",
     *     @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", example=true),
     *         @OA\Property(property="message", type="string", example="Notification retrieved successfully"),
     *         @OA\Property(
     *             property="data",
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=3),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="New Application Received for Software Engineer"),
     *                 @OA\Property(property="description", type="string", example="John Doe has applied for the Software Engineer position at PT. One Two Three. Review the application and take the next step."),
     *                 @OA\Property(property="is_read", type="boolean", example=false),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-12 11:52:21"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-12 11:52:21"),
     *             )
     *         )
     *     )
     * ),
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
    public function recruiter()
    {
        try {
            $notification = $this->notificationService->getRecruiterNotification();

            return $this->successResponse($notification, 'Notification retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse('Service Unavailable');
        }
    }
}
