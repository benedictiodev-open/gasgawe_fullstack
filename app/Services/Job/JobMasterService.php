<?php

namespace App\Services\Job;

use App\Repositories\Jobs\JobMasterRepository;

class JobMasterService
{
    public function __construct(protected JobMasterRepository $jobMasterRepository)
    {
        $this->jobMasterRepository = $jobMasterRepository;
    }

    /**
     * Handle store a new job master
     *
     * @param data $data
     * @return \app\Models\JobMaster
     */
    public function store($data)
    {
        return $this->jobMasterRepository->store($data);
    }
}
