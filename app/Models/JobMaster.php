<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobMaster extends Model
{
    protected $table = 'job_masters';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function requirement() {
        return $this->hasMany(JobQualificationRequrements::class, 'job_id');
    }

    public function bookmark() {
        return $this->hasMany(JobBookmarks::class, 'job_id');
    }

    public function apply() {
        return $this->hasMany(JobUsersApply::class, 'job_id');
    }
}
