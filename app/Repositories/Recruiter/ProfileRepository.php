<?php

namespace App\Repositories\Recruiter;

use App\Models\User;
use App\Models\UserProfileCompany;

class ProfileRepository
{

  /**
   * @param User $user
   * @return UserProfileCompany
   */
  public function getProfile(User $user)
  {
    return UserProfileCompany::where('user_id', $user->id)->with('province', 'city')->first();
  }

  /**
   * @param User $user
   * @param UserProfileCompany|null $profile
   * @param array $data
   * @return UserProfileCompany
   */
  public function updateProfile(User $user, UserProfileCompany|null $profile, $data)
  {
    $payload = [
      ...$data,
      'user_id' => $user->id,
    ];

    if ($profile) {
      $profile->update($payload);
      return $profile;
    }

    return UserProfileCompany::create($payload);
  }
}
