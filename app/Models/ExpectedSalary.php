<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpectedSalary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'expected_salaries';

    protected $fillable = [
        'name',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active expected salary ranges
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
