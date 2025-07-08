<?php

namespace App\Services\Recruiter;

use App\Models\User;
use App\Models\UserProfileCompany;
use App\Repositories\Recruiter\ProfileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
    /**
     * Get recruiter profile
     *
     * @param User $user
     * @return UserProfileCompany|null
     */
    public function getProfile(User $user)
    {
        return $this->profileRepository->getProfile($user);
    }

    /**
     * Update recruiter profile
     *
     * @param User $user
     * @param array $data
     * @return UserProfileCompany|null
     */
    public function updateProfile(User $user, array $data)
    {
        try {
            DB::beginTransaction();

            $profile = UserProfileCompany::where('user_id', $user->id)->first();

            // Handle file upload for profile image
            if (isset($data['file_profile_image']) && $data['file_profile_image'] instanceof \Illuminate\Http\UploadedFile) {
                // Delete old profile image file if exists
                if ($profile && $profile->file_profile_image) {
                    $this->deleteFile($profile->file_profile_image);
                }
                $data['file_profile_image'] = $this->handleFileUpload($data['file_profile_image'], 'profile_image', $user->id);
            }

            $profile = $this->profileRepository->updateProfile($user, $profile, $data);

            DB::commit();

            return $profile;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return null;
        }
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

        return $file->storeAs('recruiter_files/' . $type, $fileName, 'public');
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
}
