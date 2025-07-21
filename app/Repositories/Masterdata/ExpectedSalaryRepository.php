<?php

namespace App\Repositories\Masterdata;

use App\Models\ExpectedSalary;
use Illuminate\Support\Facades\DB;

class ExpectedSalaryRepository
{
  /** 
   * @SuppressWarnings(PHPMD.StaticAccess) 
   */
  private function getQueryExpectedSalary(array $request = [])
  {
    $query = DB::table('expected_salaries')
      ->select(
        'expected_salaries.id',
        'expected_salaries.name',
        'expected_salaries.description',
        'expected_salaries.is_active',
      )
      ->whereNull('deleted_at');

    if (empty($request)) return $query;

    // Check if there's a search query in the request
    if (!empty($request['search'])) {
      $search = $request['search'];

      // Apply the search filter to the query
      $query->where(function ($query) use ($search) {
        $query->where('expected_salaries.name', 'like', '%' . $search . '%')
          ->orWhere('expected_salaries.description', 'like', '%' . $search . '%');
      });
    }

    return $query;
  }

  public function getAllExpectedSalary()
  {
    return $this->getQueryExpectedSalary()->get();
  }

  public function getPaginatedExpectedSalary($request, $perPage = 10)
  {
    return $this->getQueryExpectedSalary($request)->paginate($perPage);
  }

  public function store(array $data): ExpectedSalary
  {
    return ExpectedSalary::create($data);
  }

  public function update(int $id, array $data): ExpectedSalary
  {
    $expectedSalary = ExpectedSalary::findOrFail($id);
    $expectedSalary->update($data);
    return $expectedSalary;
  }

  public function delete(int $id): bool
  {
    $expectedSalary = ExpectedSalary::findOrFail($id);
    return $expectedSalary->delete();
  }
}
