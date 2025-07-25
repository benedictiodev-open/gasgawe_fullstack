<?php

namespace App\Services\Assessment;

use App\Repositories\Assessment\AssessmentQuestionRepository;

class AssessmentQuestionService
{
    public function __construct(protected AssessmentQuestionRepository $assessmentQuestionRepository)
    {
        $this->assessmentQuestionRepository = $assessmentQuestionRepository;
    }

    public function getQuestionAssessment()
    {
        return $this->assessmentQuestionRepository->getQuestionAssessment();
    }

    public function index($id, $query)
    {
        return $this->assessmentQuestionRepository->index($id, $query)->paginate(15);
    }

    public function store($data)
    {
        return $this->assessmentQuestionRepository->store($data);
    }

    public function update($id, $data)
    {
        return $this->assessmentQuestionRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->assessmentQuestionRepository->delete($id);
    }
}
