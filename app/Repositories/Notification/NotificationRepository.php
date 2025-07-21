<?php

namespace App\Repositories\Notification;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository
{
  /**
   * @param array $data
   * @param User $user
   * @return Notification|null
   */
  public function getApplicantNotification(array $data, User $user)
  {
    $query = DB::table('notifications')
      ->select([
        'notifications.*',
      ])
      ->join('job_users_apply', 'notifications.job_users_apply_id', '=', 'job_users_apply.id')
      ->where('notifications.user_id', $user->id);

    if (array_key_exists('status', $data)) {
      $query->where('job_users_apply.status', $data['status']);
    }

    return $query->get()->toArray();
  }

  /**
   * @param User $user
   * @return Notification|null
   */
  public function getRecruiterNotification(User $user)
  {
    return Notification::where('user_id', $user?->id)->get();
  }
}
