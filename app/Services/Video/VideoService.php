<?php

namespace App\Services\Video;

use App\Models\User;
use App\Models\Video;
use App\Repositories\Video\VideoRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoService
{
    protected $videoRepository;

    public function __construct(VideoRepository $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * 
     * Save video
     *
     * @param User $user
     * @param array $data
     * @return Video|null
     */
    public function store(User $user, array $data)
    {
        try {
            DB::beginTransaction();

            $video = $this->videoRepository->findByUserId($user);

            // Handle file upload for video
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                // Delete old video file if exists
                if ($video && $video->file) {
                    $this->deleteFile($video->file);
                }
                $data['file'] = $this->handleFileUpload($data['file'], 'video', $user->id, $user->type);
            }

            $filename = $data['file'];

            $media = FFMpeg::fromDisk('public')->open($filename);

            $metadata = $this->generateVideoMetadata($media, $filename, $user);

            $video = $this->videoRepository->store($user, $video, [...$data, ...$metadata]);

            DB::commit();

            return $video;
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return null;
        }
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * 
     * Save video with custom thumbnail
     *
     * @param User $user
     * @param array $data
     * @return Video|null
     */
    public function storeWithCustomThumbnail(User $user, array $data)
    {
        try {
            DB::beginTransaction();

            $video = $this->videoRepository->findByUserId($user);

            // Handle file upload for video
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                // Delete old video file if exists
                if ($video && $video->file) {
                    $this->deleteFile($video->file);
                }
                $data['path'] = $this->handleFileUpload($data['file'], 'video', $user->id, $user->type);
            }

            // Handle file upload for thumbnail
            if (isset($data['thumbnail_file']) && $data['thumbnail_file'] instanceof \Illuminate\Http\UploadedFile) {
                // Delete old thumbnail file if exists
                if ($video && $video->thumbnail_file) {
                    $this->deleteFile($video->thumbnail_file);
                }
                $data['thumbnail_path'] = $this->handleFileUpload($data['thumbnail_file'], 'thumbnail', $user->id, $user->type);
            }

            $data['size'] = Storage::disk('public')->size($data['path']);
            $data['duration'] = 0;

            $video = $this->videoRepository->store($user, $video, [...$data]);

            DB::commit();

            return $video;
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
     * @param string $fileType
     * @param int $userId
     * @param string $userType
     * @return string
     */
    private function handleFileUpload($file, $fileType, $userId, $userType)
    {
        $fileName = $fileType . '_' . $userId . '_' . time() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($userType . '_files/' . $fileType, $fileName, 'public');
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     * 
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
     * @param \ProtoneMedia\LaravelFFMpeg\MediaOpener $media
     * @param string $filePath
     * @param \App\Models\User
     * @return array
     */
    private function generateVideoMetadata($media, $filepath, $user)
    {
        $disk = 'public';

        $size = Storage::disk($disk)->size($filepath);
        $duration = $media->getDurationInSeconds();

        // Pick random second in video
        $randomSecond = random_int(1, max(1, $duration - 1));

        // Save thumbnail
        $thumbnailFileName = 'thumbnail_' . $user->id . '_' . time() . '.jpg';
        $thumbnailPath = $user->type . '_files/thumbnail/' . $thumbnailFileName;

        $media->getFrameFromSeconds($randomSecond)
            ->export()
            ->toDisk($disk)
            ->save($thumbnailPath);

        return [
            'path' => $filepath,
            'thumbnail_path' => $thumbnailPath,
            'duration' => $duration,
            'size' => $size,
        ];
    }
}
