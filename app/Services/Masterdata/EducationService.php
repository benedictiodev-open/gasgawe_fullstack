<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\EducationRepository;
use Illuminate\Http\Request;

class EducationService
{
  protected $educationRepository;

  public function __construct(EducationRepository $educationRepository)
  {
    $this->educationRepository = $educationRepository;
  }

  public function getEducation(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->educationRepository->getAllEducations();
    }

    return $this->educationRepository->getPaginatedEducations($request?->all());
  }

  public function store(array $data)
  {
    return $this->educationRepository->store($data);
  }

  public function update(int $id, array $data)
  {
    return $this->educationRepository->update($id, $data);
  }

  public function delete(int $id)
  {
    return $this->educationRepository->delete($id);
  }
}
