<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobQualificationRequrements extends Model
{
    protected $table = 'job_qualification_and_requirements';
    protected $guarded = ['id'];

    public function jobs() {
        return $this->belongsTo(JobMaster::class, 'job_id');
    }
}
