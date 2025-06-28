<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indonesia_cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'province_code',
        'name',
        'meta'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the province that owns the city.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    /**
     * Get the districts for the city.
     */
    public function districts()
    {
        return $this->hasMany(District::class, 'city_code', 'code');
    }

    /**
     * Get the villages for the city.
     */
    public function villages()
    {
        return $this->hasManyThrough(Village::class, District::class, 'city_code', 'district_code', 'code', 'code');
    }

    /**
     * Scope a query to only include active cities.
     */
    public function scopeActive($query)
    {
        return $query->where('meta->is_active', true);
    }

    /**
     * Get the city by code.
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Get the city by name.
     */
    public static function findByName($name)
    {
        return static::where('name', 'LIKE', "%{$name}%")->first();
    }

    /**
     * Get cities by province code.
     */
    public static function findByProvinceCode($provinceCode)
    {
        return static::where('province_code', $provinceCode)->get();
    }
} 