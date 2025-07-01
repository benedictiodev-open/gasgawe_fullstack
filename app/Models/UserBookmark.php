<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBookmark extends Model
{
    use HasFactory;

    protected $table = 'user_bookmarks';

    protected $fillable = [
        'user_id',
        'bookmarked_user_id'
    ];

    /**
     * Get the user who created the bookmark
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the user being bookmarked
     */
    public function bookmarkedUser()
    {
        return $this->belongsTo(User::class, 'bookmarked_user_id');
    }
} 