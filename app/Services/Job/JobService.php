<?php

namespace App\Services\Job;

use App\Models\JobBookmarks;
use App\Models\JobMaster;
use App\Models\JobSkills;
use App\Models\JobQualificationRequrements;
use App\Models\JobUsersApply;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobService
{

    public function __construct(protected JobMasterService $jobMasterService, protected JobSkillService $jobSkillService)
    {
        $this->jobMasterService = $jobMasterService;
        $this->jobSkillService = $jobSkillService;
    }

    public function store_job_master($data, $user_id)
    {
        try {
            return DB::transaction(function () use ($data, $user_id) {
                $job_master = $this->jobMasterService->store([
                    "created_by" => $user_id,
                    "position" => $data["position"],
                    "province_id" => $data["province_id"],
                    "city_id" => $data["city_id"],
                    "employment_type_id" => $data["employment_type_id"],
                    "experience_id" => $data["experience_id"],
                    "expected_salary_id" => $data["expected_salary_id"],
                    "education_id" => $data["education_id"],
                    "description" => $data["job_description"],
                    "qualification" => $data["qualification"],
                    "image" => $data["image"],
                ]);

                foreach ($data["skills"] as $skill) {
                    if (gettype($skill) == 'string') {
                        $skill_id = explode(',', $skill);
                        foreach ($skill_id as $id) {
                            $this->jobSkillService->store([
                                "job_id" => $job_master->id,
                                "skill_id" => $id
                            ]);
                        }
                    } else {
                        $this->jobSkillService->store([
                            "job_id" => $job_master->id,
                            "skill_id" => $skill
                        ]);
                    }
                }
                return $job_master;
            });
        } catch (Exception $error) {
            throw $error;
        }
    }

    /**
     * Handle file upload
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param int $userId
     * @return string
     */
    public function handleFileUpload($file, $userId)
    {
        $fileName = $userId . '_' . time() . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('jobs', $fileName, 'public');

        return $filePath;
    }

    /**
     * Get all jobs with simple pagination for applicant
     *
     * @param int $userId
     * @param int $perPage
     * @param array $filters
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getJobRecommendations($userId, $perPage = 10, $filters = [])
    {
        try {
            // Get all active jobs with pagination
            $jobs = JobMaster::query()
                ->with([
                    'skills',
                    'skills.skill',
                    'employmentType',
                    'experience',
                    'education',
                    'expectedSalary',
                    'province',
                    'city',
                    'bookmark' => function($query) use($userId) {
                        $query->where('user_id', $userId);
                    },
                    'apply' => function($query) use($userId) {
                        $query->where('user_id', $userId);
                    }
                ])
                ->where('status', 'active')
                ->where('created_by', '!=', $userId); // Exclude jobs created by the applicant

            // Apply filters
            if (!empty($filters)) {
                // Filter by skills
                if (!empty($filters['skills'])) {
                    $skillIds = is_array($filters['skills']) ? $filters['skills'] : explode(',', $filters['skills']);
                    $jobs->whereHas('skills', function($query) use ($skillIds) {
                        $query->whereIn('skill_id', $skillIds);
                    });
                }

                // Filter by province
                if (!empty($filters['province_id'])) {
                    $jobs->where('province_id', $filters['province_id']);
                }

                // Filter by city
                if (!empty($filters['city_id'])) {
                    $jobs->where('city_id', $filters['city_id']);
                }

                // Filter by employment type
                if (!empty($filters['employment_type_id'])) {
                    $jobs->where('employment_type_id', $filters['employment_type_id']);
                }

                // Filter by expected salary
                if (!empty($filters['expected_salary_id'])) {
                    $jobs->where('expected_salary_id', $filters['expected_salary_id']);
                }

                // Filter by time
                if (!empty($filters['time_filter'])) {
                    $now = now();
                    
                    switch ($filters['time_filter']) {
                        case 'most_recent':
                            // Last 24 hours
                            $jobs->where('created_at', '>=', $now->subDay());
                            break;
                        case 'this_week':
                            // This week (Monday to Sunday)
                            $jobs->where('created_at', '>=', $now->startOfWeek());
                            break;
                        case 'this_month':
                            // This month
                            $jobs->where('created_at', '>=', $now->startOfMonth());
                            break;
                        case 'any_time':
                            // No time filter - show all jobs
                            break;
                        default:
                            // Default to most recent if invalid value
                            $jobs->where('created_at', '>=', $now->subDay());
                            break;
                    }
                }
            }

            $jobs->orderBy('created_at', 'desc');

            return $jobs->simplePaginate($perPage);

        } catch (Exception $error) {
            Log::error('Error getting job recommendations: ' . $error->getMessage());
            throw $error;
        }
    }

    public function update_status_job($data, $user_id)
    {
        try {
            $job = JobMaster::find($data['job_id']);
            if ($job->created_by != $user_id) {
                throw new Exception("You are not authorized to update this job");
            }
            $job->status = $data['status'];
            $job->save();
            return $job;
        } catch (Exception $error) {
            throw $error;
        }
    }

    public function delete_job($data, $user_id)
    {
        try {
            $job = JobMaster::find($data['job_id']);
            if ($job->created_by != $user_id) {
                throw new Exception("You are not authorized to delete this job");
            }
            $job->delete();
            return $job;
        } catch (Exception $error) {
            throw $error;
        }
    }
}
