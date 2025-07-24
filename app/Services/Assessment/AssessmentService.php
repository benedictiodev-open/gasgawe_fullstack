<?php

namespace App\Services\Assessment;

use App\Repositories\Assessment\AssessmentRepository;

class AssessmentService
{
    public function __construct(protected AssessmentRepository $assessmentRepository)
    {
        $this->assessmentRepository = $assessmentRepository;
    }

    public function index($query)
    {
        return $this->assessmentRepository->index($query)->paginate(15);
    }

    public function store($data)
    {
        return $this->assessmentRepository->store($data);
    }

    public function update($id, $data)
    {
        return $this->assessmentRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->assessmentRepository->delete($id);
    }

    public function answer($data)
    {
        return $this->assessmentRepository->answer($data);
    }
}
