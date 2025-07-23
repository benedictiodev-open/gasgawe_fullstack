<?php

namespace App\Repositories\Assessment;

use App\Models\AssessmentOption;

class AssessmentOptionRepository
{
    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function queryAssessmentOption($request)
    {
        $query = AssessmentOption::query();

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
        return $this->queryAssessmentOption($request)->where('assessment_question_id', $id);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function store($request)
    {
        return AssessmentOption::query()->create($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function update($id, $request)
    {
        return AssessmentOption::query()->findOrFail($id)->update($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function delete($id)
    {
        return AssessmentOption::query()->findOrFail($id)->delete();
    }
}
