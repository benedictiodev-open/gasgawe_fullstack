<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function skillGroup()
    {
        return $this->belongsTo(SkillGroup::class);
    }
}
