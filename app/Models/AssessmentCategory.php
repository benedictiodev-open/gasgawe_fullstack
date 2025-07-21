<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentCategory extends Model
{
    protected $table = 'assessment_categories';
    protected $guarded = ['id'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class, 'assessment_category_id');
    }
}
