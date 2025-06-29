<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEducationApplicant extends Model
{
    use HasFactory;

    protected $table = 'user_education_applicants';

    protected $fillable = [
        'user_id',
        'school_name',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'description',
        'grade',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the user that owns the education.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the profile that owns this education.
     */
    public function profile()
    {
        return $this->belongsTo(UserProfileApplicant::class, 'user_id', 'user_id');
    }
} 