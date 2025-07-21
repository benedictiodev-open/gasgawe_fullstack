<?php

namespace App\Services\Job;

use App\Models\JobUsersApply;

class JobUsersApplyService
{
    public function getJobUsersApply()
    {
        return JobUsersApply::query()->with(["jobs", "user.profileApplicant"])->paginate(15);
    }

    public function getDetailJobUsersApply($id)
    {
        return JobUsersApply::query()->with(["jobs", "user.profileApplicant"])->findOrFail($id);
    }
}
