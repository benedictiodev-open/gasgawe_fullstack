<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssesmentAnswer extends Model
{
    protected $table = 'assessment_answers';
    protected $fillable = ['user_id', 'question_id', 'option_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class);
    }

    public function option()
    {
        return $this->belongsTo(AssessmentOption::class);
    }
}
