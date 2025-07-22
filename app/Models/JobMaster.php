<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobMaster extends Model
{
    protected $table = 'job_masters';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookmark()
    {
        return $this->hasMany(JobBookmarks::class, 'job_id');
    }

    public function apply()
    {
        return $this->hasMany(JobUsersApply::class, 'job_id');
    }

    public function skills()
    {
        return $this->hasMany(JobSkill::class, 'job_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function employmentType()
    {
        return $this->belongsTo(EmploymentType::class, 'employment_type_id');
    }

    public function experience()
    {
        return $this->belongsTo(Experience::class, 'experience_id');
    }

    public function education()
    {
        return $this->belongsTo(Education::class, 'education_id');
    }

    public function expectedSalary()
    {
        return $this->belongsTo(ExpectedSalary::class, 'expected_salary_id');
    }

    /**
     * Get full location attribute
     */
    public function getFullLocationAttribute()
    {
        return trim($this->city->name . ', ' . $this->province->name);
    }

    /**
     * Get full location attribute
     */
    public function getCompanyNameAttribute()
    {
        return trim($this->user->profileCompany->company_name);
    }
}
