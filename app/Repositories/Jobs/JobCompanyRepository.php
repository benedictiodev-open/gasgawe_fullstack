<?php

namespace App\Repositories\Jobs;

use App\Models\User;
use App\Models\UserProfileCompany;

class JobCompanyRepository
{
    /**
     * Query get data from Eloquent
     * 
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function query()
    {
        return User::with('profileCompany', 'profileCompany.industryType', 'profileCompany.province', 'profileCompany.city')
            ->where('type', 'recruiter');
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
            $query->whereHas('profileCompany', function ($query) use ($search, $filterBy, $filter) {
                // Apply search
                if ($search != '') {
                    $query->where('company_name', 'like', '%' . $search . '%')->orWhereHas('industryType', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
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
        $query = UserProfileCompany::query()->findOrFail($id, 'user_id');
        return $query->update($data);
    }
}
