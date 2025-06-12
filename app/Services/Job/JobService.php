<?php

namespace App\Services\Job;

use App\Models\JobMaster;
use Exception;
use Illuminate\Support\Facades\Auth;

class JobService 
{
    public function get_list_job() {
        try {
            $user_id = Auth::guard('sanctum')->user()->id;
            $jobs_list = JobMaster::where('created_by', $user_id)->get();

            return $jobs_list;
        } catch (Exception $error) {
            throw $error;
        }
    }
}