<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndustryType extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'industry_types';

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Scope to get only active expected salary ranges
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
