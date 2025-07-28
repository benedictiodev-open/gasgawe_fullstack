<?php

namespace App\Services\Job;

use App\Repositories\Jobs\JobUserApplyRepository;

class JobUsersApplyService
{
    public function __construct(protected JobUserApplyRepository $jobUserApplyRepository)
    {
        $this->jobUserApplyRepository = $jobUserApplyRepository;
    }

    public function index($request)
    {
        return $this->jobUserApplyRepository->index($request);
    }

    public function show($id)
    {
        return $this->jobUserApplyRepository->show($id);
    }

    public function update($id, $data)
    {
        return $this->jobUserApplyRepository->update($id, $data);
    }
}
