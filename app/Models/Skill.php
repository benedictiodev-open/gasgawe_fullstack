<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $guarded = ['id'];

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skillGroup()
    {
        return $this->belongsTo(SkillGroup::class);
    }
}
