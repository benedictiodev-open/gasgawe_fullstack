<?php

namespace App\Services\Job;

use App\Models\JobBookmarks;
use App\Models\JobMaster;
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

    public function get_list_job($user_id, $type, $filters = [])
    {
        try {
            $jobs_list = JobMaster::query();

            if ($type == 'applicant') {
                $jobs_list->with('bookmark', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })->with('apply', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                });
            } else {
                $jobs_list->where('created_by', $user_id)->with(['apply']);
            }

            // Apply filters if provided
            if (!empty($filters) && is_array($filters)) {
                foreach ($filters as $key => $value) {
                    if ($key === 'created_at' && is_array($value) && count($value) === 2) {
                        $jobs_list->whereBetween('created_at', [$value[0], $value[1]]);
                    } elseif ($key === 'salary') {
                        if (is_array($value) && count($value) === 2) {
                            // Filter jobs where salary range overlaps with the given range
                            $jobs_list->where(function ($query) use ($value) {
                                $query->where('min_salary', '<=', $value[1])
                                    ->where('max_salary', '>=', $value[0]);
                            });
                        } elseif (!is_array($value) && $value !== '' && $value !== null) {
                            // Filter jobs where min_salary <= value and max_salary >= value
                            $jobs_list->where('min_salary', '<=', $value)
                                ->where('max_salary', '>=', $value);
                        }
                    } elseif (!is_null($value) && $value !== '' && $key !== 'created_at' && $key !== 'salary') {
                        $jobs_list->where($key, $value);
                    }
                }
            }

            return $jobs_list->get();
        } catch (Exception $error) {
            throw $error;
        }
    }

    public function get_detail_job($job_id, $type, $user_id)
    {
        try {
            $detail_job = JobMaster::query()
                ->with(['requirement'])
                ->where('id', $job_id);

            if ($type == 'applicant') {
                $detail_job->with('bookmark', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })->with('apply', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                });
            } else {
                $detail_job->with('apply');
            }

            return $detail_job->first();
        } catch (Exception $error) {
            throw $error;
        }
    }

    public function bookmark_job($job_id, $user_id)
    {
        try {
            $bookmark = JobBookmarks::where("job_id", $job_id)->where("user_id", $user_id)->first();

            if ($bookmark) {
                $message = "Success unmarked job";
                $bookmark = $bookmark->delete();
            } else {
                $message = "Success added bookmark job";
                $bookmark = JobBookmarks::create(["job_id" => $job_id, "user_id" => $user_id]);
            }

            return (object) [
                "message" => $message,
                "data" => $bookmark,
            ];
        } catch (Exception $error) {
            throw $error;
        }
    }

    public function apply_job($job_id, $user_id)
    {
        try {
            $apply = JobUsersApply::where("job_id", $job_id)->where("user_id", $user_id)->first();

            if ($apply) {
                $message = "You have applied for this job";
            } else {
                $message = "Success applied for this job";
                $apply = JobUsersApply::create(["job_id" => $job_id, "user_id" => $user_id]);
            }

            return (object) [
                "message" => $message,
                "data" => $apply,
            ];;
        } catch (Exception $error) {
            throw $error;
        }
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

    public function on_tranding()
    {
        try {
            $list = JobUsersApply::selectRaw('job_masters.created_by, COUNT(job_users_apply.id) as total_apply')
                ->join('job_masters', 'job_users_apply.job_id', '=', 'job_masters.id')
                ->groupBy('job_masters.created_by')
                ->orderByDesc('total_apply')
                ->limit(10)->get();

            $result = array();
            foreach ($list as $item) {
                $data_job = JobMaster::with('user')->where('created_by', $item->created_by)->first();
                $data_job_count = JobMaster::where('created_by', $item->created_by)->count();

                array_push($result, (object) [
                    "name" => $data_job->user->name,
                    "city" => $data_job->city,
                    "country" => $data_job->country,
                    "total_job" => $data_job_count,
                ]);
            }

            return $result;
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
}
