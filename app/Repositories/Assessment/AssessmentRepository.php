<?php

namespace App\Repositories\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssesmentAnswer;

class AssessmentRepository
{

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function index($request)
    {
        $query = Assessment::query();

        if (empty($request)) return $query;

        // Check if there's a search query in the request
        if (!empty($request['search'])) {
            $search = $request['search'];

            // Apply the search filter to the query
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('role', 'like', '%' . $search . '%');
            });
        }

        return $query;
    }


    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function store($request)
    {
        return Assessment::create($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function update($id, $request)
    {
        return Assessment::query()->findOrFail($id)->update($request);
    }

    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function delete($id)
    {
        return Assessment::query()->findOrFail($id)->delete();
    }

    public function answer($data)
    {
        return AssesmentAnswer::create($data);
    }

    public function calculateAnswer($user_id)
    {
        return AssesmentAnswer::query()->where('user_id', $user_id)->with(['option', 'question'])->get();
    }
}
