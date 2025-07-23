<?php

namespace App\Services\Assessment;

use App\Repositories\Assessment\AssessmentOptionRepository;

class AssessmentOptionService
{
    public function __construct(protected AssessmentOptionRepository $assessmentOptionRepository)
    {
        $this->assessmentOptionRepository = $assessmentOptionRepository;
    }

    public function index($id, $query)
    {
        return $this->assessmentOptionRepository->index($id, $query)->paginate(15);
    }

    public function store($data)
    {
        return $this->assessmentOptionRepository->store($data);
    }

    public function update($id, $data)
    {
        return $this->assessmentOptionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->assessmentOptionRepository->delete($id);
    }
}
