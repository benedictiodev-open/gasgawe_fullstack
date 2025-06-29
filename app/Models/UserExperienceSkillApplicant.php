<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExperienceSkillApplicant extends Model
{
    use HasFactory;

    protected $table = 'user_experience_skill_applicants';

    protected $fillable = [
        'experience_id',
        'skill_id'
    ];

    /**
     * Get the experience that owns the skill.
     */
    public function experience()
    {
        return $this->belongsTo(UserExperienceApplicant::class, 'experience_id');
    }

    /**
     * Get the skill that belongs to the experience.
     */
    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    /**
     * Get the user through the experience.
     */
    public function user()
    {
        return $this->hasOneThrough(
            User::class,
            UserExperienceApplicant::class,
            'id',
            'id',
            'experience_id',
            'user_id'
        );
    }
} 