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

    public function questions()
    {
        return $this->hasManyThrough(
            AssessmentQuestion::class,
            AssessmentCategory::class,
            'assessment_id',
            'assessment_category_id',
            'id',
            'id'
        );
    }

    public function questionsCount()
    {
        return $this->questions()->count();
    }
}
