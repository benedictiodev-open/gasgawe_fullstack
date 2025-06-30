<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'device_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profileApplicant() {
        return $this->hasOne(UserProfileApplicant::class, 'user_id');
    }

    public function profileCompany() {
        return $this->hasOne(UserProfileEmployer::class, 'user_id');
    }

    public function experience() {
        return $this->hasMany(UserExperienceApplicant::class, 'user_id');
    }

    public function experienceSkillApplicant() { 
        return $this->hasMany(UserExperienceSkillApplicant::class, 'user_id');
    }

    public function educationApplicant() {
        return $this->hasMany(UserEducationApplicant::class, 'user_id');
    }
    
}
