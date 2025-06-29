<?php

namespace App\Services\Applicant;

use App\Models\User;
use App\Models\UserProfileApplicant;
use App\Models\UserEducationApplicant;
use App\Models\UserExperienceApplicant;
use App\Models\UserExperienceSkillApplicant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Update advanced profile information
     *
     * @param User $user
     * @param array $data
     * @return UserProfileApplicant
     */
    public function updateAdvancedProfile($user, $data)
    {
        $profile = UserProfileApplicant::where('user_id', $user->id)->first();

        if (!$profile) {
            $profile = new UserProfileApplicant();
            $profile->user_id = $user->id;
        }

        // Update basic profile fields
        if (isset($data['bio']) && !empty($data['bio'])) {
            $profile->bio = $data['bio'];
        }

        // Handle file uploads with old file deletion
        if (isset($data['file_cv']) && $data['file_cv'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old CV file if exists
            if ($profile->file_cv) {
                $this->deleteFile($profile->file_cv);
            }
            $profile->file_cv = $this->handleFileUpload($data['file_cv'], 'cv', $user->id);
        }
        
        if (isset($data['file_cover_letter']) && $data['file_cover_letter'] instanceof \Illuminate\Http\UploadedFile) {
            // Delete old cover letter file if exists
            if ($profile->file_cover_letter) {
                $this->deleteFile($profile->file_cover_letter);
            }
            $profile->file_cover_letter = $this->handleFileUpload($data['file_cover_letter'], 'cover_letter', $user->id);
        }

        $profile->save();

        // Handle career history
        if (isset($data['career_history'])) {
            $this->updateCareerHistory($user->id, $data['career_history']);
        }

        // Handle education history
        if (isset($data['education'])) {
            $this->updateEducationHistory($user->id, $data['education']);
        }

        return $profile->fresh()->load(['careerHistory', 'educationHistory']);
    }

    /**
     * Handle file upload
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $type
     * @param int $userId
     * @return string
     */
    private function handleFileUpload($file, $type, $userId)
    {
        $fileName = $type . '_' . $userId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('applicant_files/' . $type, $fileName, 'public');
        
        return $filePath;
    }

    /**
     * Delete file from storage
     *
     * @param string $filePath
     * @return bool
     */
    private function deleteFile($filePath)
    {
        try {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                return Storage::disk('public')->delete($filePath);
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Error deleting file: ' . $filePath . ' - ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update career history
     *
     * @param int $userId
     * @param array $careerHistory
     * @return void
     */
    private function updateCareerHistory($userId, $careerHistory)
    {
        if (gettype($careerHistory) == 'string') {
            $careerHistory = json_decode($careerHistory, true);
        }
        
        if (empty($careerHistory)) {
            return;
        }

        // Delete existing career history
        $data_id_experience = UserExperienceApplicant::where('user_id', $userId)->pluck('id');
        UserExperienceSkillApplicant::whereIn('experience_id', $data_id_experience)->delete();
        UserExperienceApplicant::where('user_id', $userId)->delete();

        foreach ($careerHistory as $career) {
            $careerData = [
                'user_id' => $userId,
                'company_name' => $career['company_name'] ?? null,
                'position' => $career['position'] ?? null,
                'start_date' => $career['start_date'] ?? null,
                'end_date' => $career['end_date'] ?? null,
                'description' => $career['description'] ?? null,
                'employment_type_id' => $career['employment_type_id'] ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $careerId = UserExperienceApplicant::insertGetId($careerData);

            // Handle skills for this career entry
            if (isset($career['skills']) && is_array($career['skills'])) {
                foreach ($career['skills'] as $skillId) {
                    UserExperienceSkillApplicant::create([
                        'user_experience_id' => $careerId,
                        'skill_id' => $skillId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
    }

    /**
     * Update education history
     *
     * @param int $userId
     * @param array $educationHistory
     * @return void
     */
    private function updateEducationHistory($userId, $educationHistory)
    {
        if (gettype($educationHistory) == 'string') {
            $educationHistory = json_decode($educationHistory, true);
        }

        if (empty($educationHistory)) {
            return;
        }

        // Delete existing education history
        UserEducationApplicant::where('user_id', $userId)->delete();

        foreach ($educationHistory as $education) {
            UserEducationApplicant::create([
                'user_id' => $userId,
                'institution' => $education['institution'] ?? null,
                'degree' => $education['degree'] ?? null,
                'field_of_study' => $education['field_of_study'] ?? null,
                'start_date' => $education['start_date'] ?? null,
                'end_date' => $education['end_date'] ?? null,
                'description' => $education['description'] ?? null,
                'grade' => $education['grade'] ?? null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
} 