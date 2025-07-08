<?php

namespace App\Repositories\Video;

use App\Models\User;
use App\Models\Video;

class VideoRepository
{
  /**
   * @param User $user
   * @return Video|null
   */
  public function findByUserId(User $user)
  {
    return Video::where('user_id', $user?->id)->first();
  }

  /**
   * @param User $user
   * @param Video|null $video
   * @param array $data
   * @return Video
   */
  public function store(User $user, Video|null $video, $data)
  {
    if (!$video) {
      $video = Video::create([
        'user_id' => $user->id,
        ...$data
      ]);
    } else {
      $video->update($data);
    }

    return $video;
  }
}
