<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndustryType extends Model
{
    use HasFactory;

    protected $table = 'industry_types';

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
