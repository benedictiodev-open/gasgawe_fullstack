<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\ExpectedSalaryRepository;
use Illuminate\Http\Request;

class ExpectedSalaryService
{
  protected $expectedSalaryRepository;

  public function __construct(ExpectedSalaryRepository $expectedSalaryRepository)
  {
    $this->expectedSalaryRepository = $expectedSalaryRepository;
  }

  public function getExpectedSalary(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->expectedSalaryRepository->getAllExpectedSalary();
    }

    return $this->expectedSalaryRepository->getPaginatedExpectedSalary($request?->all());
  }

  public function store(array $data)
  {
    return $this->expectedSalaryRepository->store($data);
  }

  public function update(int $id, array $data)
  {
    return $this->expectedSalaryRepository->update($id, $data);
  }

  public function delete(int $id)
  {
    return $this->expectedSalaryRepository->delete($id);
  }
}
