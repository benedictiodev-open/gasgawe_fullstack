<?php

namespace App\Repositories\Jobs;

use App\Models\JobSkill;

class JobSkillRepository
{
    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function store($data)
    {
        return JobSkill::query()->create($data);
    }

    public function deleteByJobId($job_id)
    {
        return JobSkill::query()->where('job_id', $job_id)->delete();
    }
}
