<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobMaster extends Model
{
    protected $table = 'job_masters';
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
