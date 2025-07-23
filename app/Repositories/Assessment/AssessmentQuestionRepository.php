<?php

namespace App\Repositories\Assessment;

use App\Models\AssessmentQuestion;

class AssessmentQuestionRepository
{
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
