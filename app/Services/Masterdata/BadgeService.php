<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\BadgeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BadgeService
{
  protected $badgeRepository;

  public function __construct(BadgeRepository $badgeRepository)
  {
    $this->badgeRepository = $badgeRepository;
  }

  public function getBadge(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->badgeRepository->getAllBadges();
    }

    return $this->badgeRepository->getPaginatedBadges($request?->all());
  }

  public function getApplicantBadge()
  {
    return $this->badgeRepository->getApplicantBadges();
  }

  public function getRecruiterBadge()
  {
    return $this->badgeRepository->getRecruiterBadges();
  }

  public function store(array $data)
  {
    try {
      DB::beginTransaction();

      // Handle file upload for profile image
      if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
        $data['image_path'] = $this->handleFileUpload($data['image'], $data['type']);
      }

      $badge = $this->badgeRepository->store($data);

      DB::commit();
      return $badge;
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::error($th->getMessage());
      return null;
    }
  }

  public function update(int $id, array $data)
  {
    try {
      DB::beginTransaction();

      $badge = $this->badgeRepository->find($id);

      // Handle file upload for badge image
      if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
        // Delete old badge image file if exists
        if ($badge && $badge->image_path) {
          $this->deleteFile($badge->image_path);
        }
        $data['image_path'] = $this->handleFileUpload($data['image'], $data['type']);
      }

      $badge = $this->badgeRepository->update($id, $data);

      DB::commit();

      return $badge;
    } catch (\Throwable $th) {
      DB::rollBack();
      Log::error($th->getMessage());
      return null;
    }
  }

  public function delete(int $id)
  {
    try {
      DB::beginTransaction();

      $badge = $this->badgeRepository->find($id);

      if ($badge && $badge->image_path) {
        $this->deleteFile($badge->image_path);
      }

      $badge = $this->badgeRepository->delete($id);

      DB::commit();

      return $badge;
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
   * @param string $userType
   * @return string
   */
  private function handleFileUpload($file, $userType)
  {
    $fileName = $userType . '_' . time() . '.' . $file->getClientOriginalExtension();

    return $file->storeAs('badges', $fileName, 'public');
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
