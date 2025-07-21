<?php

namespace App\Repositories\Masterdata;

use App\Models\IndustryType;
use Illuminate\Support\Facades\DB;

class IndustryTypeRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQueryIndustryType(array $request = [])
  {
    $query = DB::table('industry_types')
      ->select(
        'industry_types.id',
        'industry_types.name',
        'industry_types.description',
        'industry_types.status',
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('industry_types.name', 'like', '%' . $search . '%')
          ->orWhere('industry_types.description', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllIndustryType()
  {
    return $this->getQueryIndustryType()->get();
  }

  public function getPaginatedIndustryType($request, $perPage = 10)
  {
    return $this->getQueryIndustryType($request)->paginate($perPage);
  }

  public function store(array $data): IndustryType
  {
    return IndustryType::create($data);
  }

  public function update(int $id, array $data): IndustryType
  {
    $industryType = IndustryType::findOrFail($id);
    $industryType->update($data);
    return $industryType;
  }

  public function delete(int $id): bool
  {
    $industryType = IndustryType::findOrFail($id);
    return $industryType->delete();
  }
}
