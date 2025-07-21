<?php

namespace App\Repositories\Masterdata;

use App\Models\Education;
use Illuminate\Support\Facades\DB;

class EducationRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQueryEducation(array $request = [])
  {
    $query = DB::table('educations')
      ->select(
        'educations.id',
        'educations.name',
        'educations.description',
        'educations.is_active',
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('educations.name', 'like', '%' . $search . '%')
          ->orWhere('educations.description', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllEducations()
  {
    return $this->getQueryEducation()->get();
  }

  public function getPaginatedEducations($request, $perPage = 10)
  {
    return $this->getQueryEducation($request)->paginate($perPage);
  }

  public function store(array $data): Education
  {
    return Education::create($data);
  }

  public function update(int $id, array $data): Education
  {
    $education = Education::findOrFail($id);
    $education->update($data);
    return $education;
  }

  public function delete(int $id): bool
  {
    $education = Education::findOrFail($id);
    return $education->delete();
  }
}
