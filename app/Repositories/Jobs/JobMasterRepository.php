<?php

namespace App\Repositories\Jobs;

use App\Models\JobMaster;

class JobMasterRepository
{
    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function store($data)
    {
        return JobMaster::query()->create($data);
    }
}
