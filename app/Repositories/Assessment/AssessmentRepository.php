<?php

namespace App\Repositories\Assessment;

use App\Models\Assessment;

class AssessmentRepository
{
    /** 
     * @SuppressWarnings(PHPMD.StaticAccess) 
     */
    public function index()
    {
        return Assessment::query()->with(['categories' => function ($query) {
            $query->with(['questions' => function ($query) {
                $query->with('options');
            }]);
        }])->get();
    }
}
