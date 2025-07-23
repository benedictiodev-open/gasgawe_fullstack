<?php

namespace App\Repositories\Masterdata;

use App\Models\Badge;
use Illuminate\Support\Facades\DB;

class BadgeRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQueryBadge(array $request = [])
  {
    $query = DB::table('badges')
      ->select(
        'badges.id',
        'badges.name',
        'badges.description',
        'badges.image_path',
        'badges.type',
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('badges.name', 'like', '%' . $search . '%')
          ->orWhere('badges.description', 'like', '%' . $search . '%')
          ->orWhere('badges.type', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllBadges()
  {
    return $this->getQueryBadge()->get();
  }

  public function getPaginatedBadges($request, $perPage = 10)
  {
    return $this->getQueryBadge($request)->paginate($perPage);
  }

  public function getApplicantBadges()
  {
    return $this->getQueryBadge()->where('type', 'Applicant')->get();
  }

  public function getRecruiterBadges()
  {
    return $this->getQueryBadge()->where('type', 'Recruiter')->get();
  }

  public function find(int $id): Badge
  {
    return Badge::findOrFail($id);
  }

  public function store(array $data): Badge
  {
    return Badge::create($data);
  }

  public function update(int $id, array $data): Badge
  {
    $badge = Badge::findOrFail($id);
    $badge->update($data);
    return $badge;
  }

  public function delete(int $id): bool
  {
    $badge = Badge::findOrFail($id);
    return $badge->delete();
  }
}
