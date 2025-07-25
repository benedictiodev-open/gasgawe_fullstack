<?php

namespace App\Services\Assessment;

use App\Models\User;
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

    public function calculateScore($user_id)
    {
        $answers = $this->assessmentRepository->calculateAnswer($user_id);
        $sum = 0;
        foreach ($answers as $key => $value) {
            $sum += $value->option->score_conversion;
        }
        $score = $sum / count($answers);

        $user = User::query()->findOrFail($user_id);
        $user->update([
            "exp" => $score,
        ]);

        return (object)[
            "score" => $score,
            "total_answers" => count($answers),
            "user" => $user,
        ];
    }
}
