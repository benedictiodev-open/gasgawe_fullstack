<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indonesia_villages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'district_code',
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
     * Get the district that owns the village.
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }

    /**
     * Get the city that owns the village.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'district.city_code', 'code');
    }

    /**
     * Get the province that owns the village.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'district.city.province_code', 'code');
    }

    /**
     * Scope a query to only include active villages.
     */
    public function scopeActive($query)
    {
        return $query->where('meta->is_active', true);
    }

    /**
     * Get the village by code.
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Get the village by name.
     */
    public static function findByName($name)
    {
        return static::where('name', 'LIKE', "%{$name}%")->first();
    }

    /**
     * Get villages by district code.
     */
    public static function findByDistrictCode($districtCode)
    {
        return static::where('district_code', $districtCode)->get();
    }
} 