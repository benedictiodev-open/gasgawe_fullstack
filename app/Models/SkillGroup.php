<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillGroup extends Model
{
    protected $guarded = ['id'];

    /**
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function skill()
    {
        return $this->hasMany(Skill::class);
    }
}
