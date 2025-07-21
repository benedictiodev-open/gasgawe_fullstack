<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileApplicant extends Model
{
    use HasFactory;

    protected $table = 'user_profile_applicants';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'province_id',
        'city_id',
        'address',
        'phone',
        'bio',
        'profile_picture',
        'resume_file',
        'file_cv',
        'file_cover_letter',
        'file_profile_image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the province for this profile.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    /**
     * Get the city for this profile.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Get the career history for this profile.
     */
    public function careerHistory()
    {
        return $this->hasMany(UserExperienceApplicant::class, 'user_id', 'user_id');
    }

    /**
     * Get the education history for this profile.
     */
    public function educationHistory()
    {
        return $this->hasMany(UserEducationApplicant::class, 'user_id', 'user_id');
    }


    /**
     * Get the experience level for this profile.
     */
    public function experience()
    {
        return $this->belongsTo(Experience::class, 'experience_id');
    }

    /**
     * Get the education level for this profile.
     */
    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    /**
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    /**
     * Get full location attribute
     */
    public function getFullLocationAttribute()
    {
        return trim($this->city->name . ', ' . $this->province->name);
    }

    /**
     * Get age attribute
     */
    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            return $this->date_of_birth->age;
        }
        return null;
    }
}
