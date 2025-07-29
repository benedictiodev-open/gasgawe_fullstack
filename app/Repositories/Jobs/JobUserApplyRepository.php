<?php

namespace App\Repositories\Jobs;

use App\Models\JobUsersApply;
use App\Models\User;

class JobUserApplyRepository
{
    /**
     * Query get data from Eloquent
     * 
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function query()
    {
        return User::query()->with(["profileApplicant", "profileApplicant.city", "profileApplicant.province"])->where('type', 'applicant');
    }

    /**
     * Get all user apply
     * @param request $request request query params
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function index($request)
    {
        $query = $this->query();

        // Check if there's a search query in the request
        if (!empty($request['search']) || !empty($request['filterBy']) || !empty($request['filter'])) {
            $search = isset($request['search']) ? $request['search'] : '';
            $filterBy = isset($request['filterBy']) ? $request['filterBy'] : [];
            $filter = isset($request['filter']) ? $request['filter'] : '';

            // Apply the search filter to the query
            $query->whereHas('user.profileApplicant', function ($query) use ($search, $filterBy, $filter) {
                // Apply search
                if ($search != '') {
                    $query->where('first_name', 'like', '%' . $search . '%')
                        ->orWhere('last_name', 'like', '%' . $search . '%');
                }

                // Apply filter
                if (count($filterBy) > 0 || $filter) {
                    // Filter Location
                    if (in_array('location', $filterBy)) {
                        $query->whereHas('user.profileApplicant.city', function ($q) use ($filter) {
                            $q->where('name', 'LIKE', "%$filter%");
                        })->orWhereHas('user.profileApplicant.province', function ($q) use ($filter) {
                            $q->where('name', 'LIKE', "%$filter%");
                        });
                    }

                    // Filter Level
                    if (in_array('level', $filterBy)) {
                        $query->whereHas('user', function ($q) use ($filter) {
                            $q->where('exp', 'LIKE', "%$filter%");
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
            });
        }

        // dd($search, $filterBy, $filter, $request, $query->count());
        return $query->paginate(15);
    }

    /**
     * Get all user apply job
     * @param request $request request query params
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function show($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Update user apply job
     * @param id $id id user apply
     * @param array $data data update user apply
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function update($id, $data)
    {
        $query = $this->query()->findOrFail($id);
        return $query->update($data);
    }
}
