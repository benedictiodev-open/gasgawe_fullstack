<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\ExperienceRepository;
use Illuminate\Http\Request;

class ExperienceService
{
  protected $experienceRepository;

  public function __construct(ExperienceRepository $experienceRepository)
  {
    $this->experienceRepository = $experienceRepository;
  }

  public function getExperience(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->experienceRepository->getAllExperiences();
    }

    return $this->experienceRepository->getPaginatedExperiences($request?->all());
  }

  public function store(array $data)
  {
    return $this->experienceRepository->store($data);
  }

  public function update(int $id, array $data)
  {
    return $this->experienceRepository->update($id, $data);
  }

  public function delete(int $id)
  {
    return $this->experienceRepository->delete($id);
  }
}
