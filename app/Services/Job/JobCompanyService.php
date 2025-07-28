<?php

namespace App\Services\Job;

use App\Repositories\Jobs\JobCompanyRepository;

class JobCompanyService
{
    public function __construct(protected JobCompanyRepository $jobCompanyRepository)
    {
        $this->jobCompanyRepository = $jobCompanyRepository;
    }

    public function index($request)
    {
        return $this->jobCompanyRepository->index($request);
    }

    public function show($id)
    {
        return $this->jobCompanyRepository->show($id);
    }

    public function update($id, $data)
    {
        return $this->jobCompanyRepository->update($id, $data);
    }
}
