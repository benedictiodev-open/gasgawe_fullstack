<?php

namespace App\Services\Masterdata;

use App\Repositories\Masterdata\SkillRepository;

class SkillService
{
  protected $skillRepository;

  public function __construct(SkillRepository $skillRepository)
  {
    $this->skillRepository = $skillRepository;
  }

  public function getSkill()
  {
    return $this->skillRepository->getSkill();
  }
}
