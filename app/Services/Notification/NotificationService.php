<?php

namespace App\Services\Notification;

use App\Repositories\Notification\NotificationRepository;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    protected $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function getApplicantNotification(array $request)
    {
        $user = Auth::guard('sanctum')->user();

        return $this->notificationRepository->getApplicantNotification($request, $user);
    }

    public function getRecruiterNotification()
    {
        $user = Auth::guard('sanctum')->user();

        return $this->notificationRepository->getRecruiterNotification($user);
    }
}
