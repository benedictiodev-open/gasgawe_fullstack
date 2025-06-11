<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobBookmarks extends Model
{
    protected $table = 'job_bookmarks';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobs() {
        return $this->belongsTo(JobMaster::class, 'job_id');
    }
}
