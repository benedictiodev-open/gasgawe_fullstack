<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\EmploymentTypeRepository;
use Illuminate\Http\Request;

class EmploymentTypeService
{
  protected $employmentTypeRepository;

  public function __construct(EmploymentTypeRepository $employmentTypeRepository)
  {
    $this->employmentTypeRepository = $employmentTypeRepository;
  }

  public function getEmploymentType(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->employmentTypeRepository->getAllEmploymentType();
    }

    return $this->employmentTypeRepository->getPaginatedEmploymentType($request?->all());
  }

  public function store(array $data)
  {
    return $this->employmentTypeRepository->store($data);
  }

  public function update(int $id, array $data)
  {
    return $this->employmentTypeRepository->update($id, $data);
  }

  public function delete(int $id)
  {
    return $this->employmentTypeRepository->delete($id);
  }
}
