<?php

namespace App\Services\Job;

use App\Models\JobBookmarks;
use App\Models\JobMaster;
use App\Models\JobQualificationRequrements;
use App\Models\JobUsersApply;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobService 
{
    public function get_list_job($user_id, $type) {
        try {
            $jobs_list = JobMaster::query();

            if ($type == 'applicant') {
                $jobs_list->with('bookmark', function($query) use($user_id) {
                    $query->where('user_id', $user_id);
                })->with('apply', function($query) use($user_id) {
                    $query->where('user_id', $user_id);
                });
            } else {
                $jobs_list->where('created_by', $user_id)->with(['apply']);
            }

            return $jobs_list->get();
        } catch (Exception $error) {
            throw $error;
        }
    }

    public function get_detail_job($job_id, $type, $user_id) {
        try {
            $detail_job = JobMaster::query()
                ->with(['requirement'])
                ->where('id', $job_id);

            if ($type == 'applicant') {
                $detail_job->with('bookmark', function($query) use($user_id) {
                    $query->where('user_id', $user_id);
                })->with('apply', function($query) use($user_id) {
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

    public function bookmark_job($job_id, $user_id) {
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

    public function apply_job($job_id, $user_id) {
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

    public function create_job($data, $user_id) {
        try {
            return DB::transaction(function() use($data, $user_id) {
                $job_master = JobMaster::create([
                    "created_by" => $user_id,
                    "title" => $data['title'],
                    "description" => $data['description'],
                    "city" => $data['city'],
                    "country" => $data['country'],
                    "deadline" => $data['deadline'],
                    "job_type" => $data['job_type'],
                    "position" => $data['position'],
                    "min_salary" => $data['min_salary'],
                    "max_salary" => $data['max_salary'],
                    "min_experience" => $data['min_experience'],
                    "max_experience" => $data['max_experience'],
                    "post_by" => $data['post_by'],
                ]);

                if (count($data['job_requirement']) > 1) {
                    foreach ($data['job_requirement'] as $item) {
                        $job_requirement = JobQualificationRequrements::create([
                            "job_id" => $job_master->id,
                            "rquirements" => $item,
                        ]);
                    }
                }
                return $job_master;
            });
        } catch (Exception $error) {
            throw $error;
        }
    }
}