<?php

namespace App\Services\Assessment;

use App\Repositories\Assessment\AssessmentCategoryRepository;
use App\Repositories\Assessment\AssessmentRepository;

class AssessmentCategoryService
{
    public function __construct(protected AssessmentCategoryRepository $assessmentCategoryRepository)
    {
        $this->assessmentCategoryRepository = $assessmentCategoryRepository;
    }

    public function index($id, $query)
    {
        return $this->assessmentCategoryRepository->index($id, $query)->paginate(15);
    }

    public function store($data)
    {
        return $this->assessmentCategoryRepository->store($data);
    }

    public function update($id, $data)
    {
        return $this->assessmentCategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->assessmentCategoryRepository->delete($id);
    }
}
