<?php

namespace App\Services\Job;

use App\Repositories\Jobs\JobSkillRepository;

class JobSkillService
{
    public function __construct(protected JobSkillRepository $jobSkillRepository)
    {
        $this->jobSkillRepository = $jobSkillRepository;
    }

    public function store($data)
    {
        return $this->jobSkillRepository->store($data);
    }
}
