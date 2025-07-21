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

    /**
     * List of job master
     *
     * @param data $data
     * @return \app\Models\JobMaster
     */
    public function index()
    {
        return $this->jobMasterRepository->index([]);
    }

    /**
     * show job by id
     *
     * @param id $id
     * @return \app\Models\JobMaster
     */
    public function show($id)
    {
        return $this->jobMasterRepository->show($id);
    }

    /**
     * update information job by id
     *
     * @param id $id
     * @return \app\Models\JobMaster
     */
    public function update($id, $data)
    {
        return $this->jobMasterRepository->update($id, $data);
    }
}
