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
}
