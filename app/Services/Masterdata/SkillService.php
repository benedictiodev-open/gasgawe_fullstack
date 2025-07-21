<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\SkillRepository;
use Illuminate\Http\Request;

class SkillService
{
  protected $skillRepository;

  public function __construct(SkillRepository $skillRepository)
  {
    $this->skillRepository = $skillRepository;
  }

  public function getSkill(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->skillRepository->getAllSkills();
    }

    return $this->skillRepository->getPaginatedSkills($request?->all());
  }

  public function getSkillGroup(Request $request = null, $all = true)
  {
    if ($all) {
      return $this->skillRepository->getAllSkillGroups();
    }

    return $this->skillRepository->getPaginatedSkillGroups($request?->all());
  }


  public function store(array $data)
  {
    return $this->skillRepository->store($data);
  }

  public function update(int $id, array $data)
  {
    return $this->skillRepository->update($id, $data);
  }

  public function delete(int $id)
  {
    return $this->skillRepository->delete($id);
  }
}
