<?php

namespace App\Repositories\Masterdata;

use App\Models\EmploymentType;
use Illuminate\Support\Facades\DB;

class EmploymentTypeRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQueryEmploymentType(array $request = [])
  {
    $query = DB::table('employment_types')
      ->select(
        'employment_types.id',
        'employment_types.name',
        'employment_types.description',
        'employment_types.is_active',
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('employment_types.name', 'like', '%' . $search . '%')
          ->orWhere('employment_types.description', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllEmploymentType()
  {
    return $this->getQueryEmploymentType()->get();
  }

  public function getPaginatedEmploymentType($request, $perPage = 10)
  {
    return $this->getQueryEmploymentType($request)->paginate($perPage);
  }

  public function store(array $data): EmploymentType
  {
    return EmploymentType::create($data);
  }

  public function update(int $id, array $data): EmploymentType
  {
    $employmentType = EmploymentType::findOrFail($id);
    $employmentType->update($data);
    return $employmentType;
  }

  public function delete(int $id): bool
  {
    $employmentType = EmploymentType::findOrFail($id);
    return $employmentType->delete();
  }
}
