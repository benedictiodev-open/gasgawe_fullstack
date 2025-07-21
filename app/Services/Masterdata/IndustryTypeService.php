<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\IndustryTypeRepository;
use Illuminate\Http\Request;

class IndustryTypeService
{
  protected $industryTypeRepository;

  public function __construct(IndustryTypeRepository $industryTypeRepository)
  {
    $this->industryTypeRepository = $industryTypeRepository;
  }

  public function getIndustryType(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->industryTypeRepository->getAllIndustryType();
    }

    return $this->industryTypeRepository->getPaginatedIndustryType($request?->all());
  }

  public function store(array $data)
  {
    return $this->industryTypeRepository->store($data);
  }

  public function update(int $id, array $data)
  {
    return $this->industryTypeRepository->update($id, $data);
  }

  public function delete(int $id)
  {
    return $this->industryTypeRepository->delete($id);
  }
}
