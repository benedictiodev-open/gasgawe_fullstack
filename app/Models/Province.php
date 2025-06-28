<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'indonesia_provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
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
     * Get the cities for the province.
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'province_code', 'code');
    }

    /**
     * Get the districts for the province.
     */
    public function districts()
    {
        return $this->hasManyThrough(District::class, City::class, 'province_code', 'city_code', 'code', 'code');
    }

    /**
     * Get the villages for the province.
     */
    public function villages()
    {
        return $this->hasManyThrough(Village::class, District::class, 'province_code', 'district_code', 'code', 'code');
    }

    /**
     * Scope a query to only include active provinces.
     */
    public function scopeActive($query)
    {
        return $query->where('meta->is_active', true);
    }

    /**
     * Get the province by code.
     */
    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }

    /**
     * Get the province by name.
     */
    public static function findByName($name)
    {
        return static::where('name', 'LIKE', "%{$name}%")->first();
    }
} 