<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    protected $table = 'assessment_questions';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(AssessmentCategory::class, 'assessment_category_id');
    }
    public function options()
    {
        return $this->hasMany(AssessmentOption::class, 'assessment_question_id');
    }
}
