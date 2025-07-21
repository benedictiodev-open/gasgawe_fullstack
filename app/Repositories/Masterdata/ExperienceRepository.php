<?php

namespace App\Repositories\Masterdata;

use App\Models\Experience;
use Illuminate\Support\Facades\DB;

class ExperienceRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQueryExperience(array $request = [])
  {
    $query = DB::table('experiences')
      ->select(
        'experiences.id',
        'experiences.name',
        'experiences.description',
        'experiences.is_active',
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('experiences.name', 'like', '%' . $search . '%')
          ->orWhere('experiences.description', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllExperiences()
  {
    return $this->getQueryExperience()->get();
  }

  public function getPaginatedExperiences($request, $perPage = 10)
  {
    return $this->getQueryExperience($request)->paginate($perPage);
  }

  public function store(array $data): Experience
  {
    return Experience::create($data);
  }

  public function update(int $id, array $data): Experience
  {
    $experience = Experience::findOrFail($id);
    $experience->update($data);
    return $experience;
  }

  public function delete(int $id): bool
  {
    $experience = Experience::findOrFail($id);
    return $experience->delete();
  }
}
