<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $guarded = ['id'];

    public function user() {
        $this->belongsTo(User::class, 'user_id');
    }
}
