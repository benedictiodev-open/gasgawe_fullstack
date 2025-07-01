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
    if (!$profile) {
      $profile = UserProfileCompany::create([
        'user_id' => $user->id,
        'company_name' => $data['company_name'],
        'established_date' => $data['established_date'],
        'province_id' => $data['province_id'],
        'city_id' => $data['city_id'],
        'employee_count' => $data['employee_count'],
        'bio' => $data['bio'],
        'file_profile_image' => $data['file_profile_image'] ?? null,
      ]);
    } else {
      $profile->update($data);
    }

    return $profile;
  }
}
