<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indonesia_districts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'city_code',
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
     * Get the city that owns the district.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_code', 'code');
    }

    /**
     * Get the province that owns the district.
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'city.province_code', 'code');
    }

    /**
     * Get the villages for the district.
     */
    public function villages()
    {
        return $this->hasMany(Village::class, 'district_code', 'code');
    }

    /**
     * Scope a query to only include active districts.
     */
    public function scopeActive($query)
    {
        return $query->where('meta->is_active', true);
    }

    /**
     * Get the district by code.
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Get the district by name.
     */
    public static function findByName($name)
    {
        return static::where('name', 'LIKE', "%{$name}%")->first();
    }

    /**
     * Get districts by city code.
     */
    public static function findByCityCode($cityCode)
    {
        return static::where('city_code', $cityCode)->get();
    }
} 