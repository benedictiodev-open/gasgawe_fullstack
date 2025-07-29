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
     * Get List of Applicant Applied Activity
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function getApplicantAppliedActivity(array $data, User $user)
    {
        $parsedStatuses = collect([
            'notice' => 'Notice',
            'review' => 'On Riview',
            'accept' => 'Accepted',
        ])->only($data['status'] ?? '')
            ->values()
            ->all() ?: ['Applied', 'Notice', 'On Riview', 'Accepted'];

        $query = DB::table('job_masters')
            ->select([
                'job_masters.id',
                'job_masters.position',
                'job_masters.description',
                'job_masters.qualification',
                'job_masters.created_at',

                'indonesia_provinces.name as province_name',
                'indonesia_cities.name as city_name',
                'employment_types.name as employment_type_name',
                'expected_salaries.name as expected_salary_name',
                'educations.name as education_name',
                'experiences.name as experience_name',
                'user_profile_companies.company_name',
                'job_users_apply.status',

                DB::raw('(
                    SELECT COUNT(*) 
                    FROM job_users_apply 
                    WHERE job_users_apply.job_id = job_masters.id 
                    AND job_users_apply.status IN (' . join(',', array_map(fn($v) => DB::getPdo()->quote($v), $parsedStatuses)) . ')
                ) as applier_count'),
            ])
            ->join('users', 'job_masters.created_by', '=', 'users.id')
            ->join('user_profile_companies', 'users.id', '=', 'user_profile_companies.user_id')
            ->leftJoin('job_users_apply', function ($join) use ($user, $parsedStatuses) {
                $join->on('job_masters.id', '=', 'job_users_apply.job_id')
                    ->where('job_users_apply.user_id', '=', $user->id)
                    ->whereIn('job_users_apply.status', $parsedStatuses);
            })
            ->leftJoin('indonesia_provinces', 'job_masters.province_id', '=', 'indonesia_provinces.id')
            ->leftJoin('indonesia_cities', 'job_masters.city_id', '=', 'indonesia_cities.id')
            ->leftJoin('employment_types', 'job_masters.employment_type_id', '=', 'employment_types.id')
            ->leftJoin('expected_salaries', 'job_masters.expected_salary_id', '=', 'expected_salaries.id')
            ->leftJoin('educations', 'job_masters.education_id', '=', 'educations.id')
            ->leftJoin('experiences', 'job_masters.experience_id', '=', 'experiences.id')
            ->whereNotNull('job_users_apply.job_id'); // ensures current user applied to the job


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
     * Query of Jobs
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function queryJobs()
    {
        return JobMaster::query()->with(['user.profileCompany', 'city', 'province']);
    }

    /**
     * Get List of Jobs
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function index($request)
    {
        $query = $this->queryJobs();

        if (!empty($request['search']) || !empty($request['filterBy']) || !empty($request['filter'])) {
            $search = isset($request['search']) ? $request['search'] : '';
            $filterBy = isset($request['filterBy']) ? $request['filterBy'] : [];
            $filter = isset($request['filter']) ? $request['filter'] : '';

            // Apply search
            if ($search != '') {
                $query->where('position', 'like', '%' . $search . '%')
                    ->orWhereHas('user.profileCompany', function ($q) use ($search) {
                        $q->where('company_name', 'LIKE', "%$search%");
                    });
            }

            // Apply filter
            if (count($filterBy) > 0 || $filter) {
                // Filter Location
                if (in_array('location', $filterBy)) {
                    $query->whereHas('city', function ($q) use ($filter) {
                        $q->where('name', 'LIKE', "%$filter%");
                    })->orWhereHas('province', function ($q) use ($filter) {
                        $q->where('name', 'LIKE', "%$filter%");
                    });
                }

                // Filter Status
                if (in_array('status', $filterBy)) {
                    $query->whereHas('user.profileApplicant', function ($q) use ($filter) {
                        if (str_contains($filter, 'not')) {
                            $q->where('is_active', 'LIKE', 0);
                        }
                        if (str_contains($filter, 'active')) {
                            $q->where('is_active', 'LIKE', 1);
                        }
                    });
                }
            }
        }


        return $query->paginate(15);
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
