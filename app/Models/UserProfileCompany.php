<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileCompany extends Model
{
    use HasFactory;

    protected $table = 'user_profile_companies';

    protected $fillable = [
        'user_id',
        'company_name',
        'established_date',
        'province_id',
        'city_id',
        'bio',
        'employee_count',
        'file_profile_image',
    ];

    protected $casts = [
        'established_date' => 'date',
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
}
