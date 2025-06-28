<?php

namespace App\Services\Applicant;

use App\Models\User;
use App\Models\UserProfileApplicant;

class ProfileService
{
    /**
     * Update applicant profile
     *
     * @param User $user
     * @param array $data
     * @return UserProfileApplicant
     */
    public function updateProfile(User $user, array $data)
    {
        try {
            $profile = UserProfileApplicant::where('user_id', $user->id)->first();
            if (!$profile) {
                $profile = UserProfileApplicant::create([
                    'user_id' => $user->id,
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'date_of_birth' => $data['date_of_birth'],
                    'gender' => $data['gender'],
                    'province_id' => $data['province_id'],
                    'city_id' => $data['city_id'],
                ]);
            } else {
                $profile->update($data);
            }

            return $profile;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get applicant profile
     *
     * @param User $user
     * @return UserProfileApplicant|null
     */
    public function getProfile(User $user)
    {
        return UserProfileApplicant::where('user_id', $user->id)->with('province', 'city')->first();
    }
} 