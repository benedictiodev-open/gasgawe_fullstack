<?php

namespace App\Repositories\Jobs;

use App\Models\JobMaster;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JobMasterRepository
{
    /**
     * Get List of Activity Recruiter
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function getActivityByUser(array $data, User $user)
    {
        $query = DB::table('job_masters')
            ->select([
                'job_masters.*',
                'indonesia_provinces.name as province_name',
                'indonesia_cities.name as city_name',
                'employment_types.name as employment_type_name',
                'expected_salaries.name as expected_salary_name',
                'educations.name as education_name',
                'experiences.name as experience_name',
            ])
            ->leftJoin('indonesia_provinces', 'job_masters.province_id', '=', 'indonesia_provinces.id')
            ->leftJoin('indonesia_cities', 'job_masters.city_id', '=', 'indonesia_cities.id')
            ->leftJoin('employment_types', 'job_masters.employment_type_id', '=', 'employment_types.id')
            ->leftJoin('expected_salaries', 'job_masters.expected_salary_id', '=', 'expected_salaries.id')
            ->leftJoin('educations', 'job_masters.education_id', '=', 'educations.id')
            ->leftJoin('experiences', 'job_masters.experience_id', '=', 'experiences.id')
            ->where('job_masters.created_by', $user->id);

        if (array_key_exists('status', $data)) {
            $query->where('job_masters.status', $data['status']);
        }

        return $query->get()->toArray();
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function store($data)
    {
        return JobMaster::query()->create($data);
    }

    /**
     * Get List of Jobs
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function index(array $data)
    {
        $query = JobMaster::query();
        if (array_key_exists('status', $data)) {
            $query->where('job_masters.status', $data['status']);
        }

        return $query->get();
    }


    /**
     * Get Detail Job
     * @param id $id job master
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function show($id)
    {
        $query = JobMaster::query()->findOrFail($id);

        return $query;
    }

    /**
     * Update Information Job
     * @param id $id job master
     * @param array $data data information update
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function update($id, $data)
    {
        $query = JobMaster::query()->find($id)->update($data);

        return $query;
    }
}
