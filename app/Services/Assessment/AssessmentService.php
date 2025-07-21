<?php

namespace App\Services\Assessment;

use App\Repositories\Assessment\AssessmentRepository;

class AssessmentService
{
    public function __construct(protected AssessmentRepository $assessmentRepository)
    {
        $this->assessmentRepository = $assessmentRepository;
    }

    public function getAssessment()
    {
        return $this->assessmentRepository->index();
    }
}
