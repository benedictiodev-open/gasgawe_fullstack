<?php

namespace App\Repositories\Assessment;

use App\Models\AssessmentQuestion;

class AssessmentQuestionRepository
{
    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function queryAssessmentQuestionAPI()
    {
        $assessments = AssessmentQuestion::query()
            ->with(['options'])
            ->leftJoin('assessment_categories', 'assessment_categories.id', '=',  'assessment_questions.assessment_category_id')
            ->leftJoin('assessments', 'assessments.id', '=',  'assessment_categories.assessment_id')
            ->selectRaw("
            assessments.id,
            assessments.name,
            assessments.role,
            assessments.total_questions,
            assessments.estimated_duration,
            assessments.scoring_system,
            assessment_categories.id AS category_id,
            assessment_categories.name AS category_name,
            assessment_categories.name AS category_description,
            assessment_questions.id AS question_id,
            assessment_questions.text AS question_text,
            assessment_questions.question_type
            ")
            ->simplePaginate(1);

        return $assessments;
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function getQuestionAssessment()
    {
        return $this->queryAssessmentQuestionAPI();
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function queryAssessmentQuestion($request)
    {
        $query = AssessmentQuestion::query();

        if (empty($request)) return $query;

        // Check if there's a search query in the request
        if (!empty($request['search'])) {
            $search = $request['search'];

            // Apply the search filter to the query
            $query->where('text', 'like', '%' . $search . '%');
        }

        return $query;
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function index($id, $request)
    {
        return $this->queryAssessmentQuestion($request)->where('assessment_category_id', $id);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function store($request)
    {
        return AssessmentQuestion::query()->create($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function update($id, $request)
    {
        return AssessmentQuestion::query()->findOrFail($id)->update($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function delete($id)
    {
        return AssessmentQuestion::query()->findOrFail($id)->delete();
    }
}
