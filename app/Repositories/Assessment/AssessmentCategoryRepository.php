<?php

namespace App\Repositories\Assessment;

use App\Models\AssessmentCategory;

class AssessmentCategoryRepository
{
    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function queryCategory($request)
    {
        $query = AssessmentCategory::query();

        if (empty($request)) return $query;

        // Check if there's a search query in the request
        if (!empty($request['search'])) {
            $search = $request['search'];

            // Apply the search filter to the query
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query;
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function index($id, $request)
    {
        return $this->queryCategory($request)->where('assessment_id', $id);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function store($request)
    {
        return AssessmentCategory::query()->create($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function update($id, $request)
    {
        return AssessmentCategory::query()->findOrFail($id)->update($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function delete($id)
    {
        return AssessmentCategory::query()->findOrFail($id)->delete();
    }
}
