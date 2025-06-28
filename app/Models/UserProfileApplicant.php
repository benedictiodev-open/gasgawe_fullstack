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
        'is_active'
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
     * Get full name attribute
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
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
