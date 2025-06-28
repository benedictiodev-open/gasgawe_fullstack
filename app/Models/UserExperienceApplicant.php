<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperienceApplicant extends Model
{
    use HasFactory;

    protected $table = 'user_experience_applicants';

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'start_date',
        'end_date',
        'description',
        'employment_type_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the experience.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the employment type for this experience.
     */
    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id');
    }

    /**
     * Get the skills for this experience.
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'user_experience_skill_applicants', 'user_experience_id', 'skill_id');
    }

    /**
     * Get the profile that owns this experience.
     */
    public function profile()
    {
        return $this->belongsTo(UserProfileApplicant::class, 'user_id', 'user_id');
    }
} 