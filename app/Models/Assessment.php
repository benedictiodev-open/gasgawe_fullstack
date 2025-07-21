<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'assessments';
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->hasMany(AssessmentCategory::class, 'assessment_id');
    }
}
