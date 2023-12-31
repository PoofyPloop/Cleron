<?php

namespace App\Models;

// StAuth10244: I Rawad Haddad, 000777218 certify that this material is my original work. No other person's work has been used without due acknowledgement. I have not made my work available to anyone else. -->

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Thread;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'thread_id',
        'user_id',
        'body'
    ];

    /**
     * Get the user that owns the Comment
     * 
     * @return BelongsTo - The user that owns the Comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the thread that owns the Comment
     * 
     * @return BelongsTo - The thread that owns the Comment
     */
    public function thread(): BelongsTo
    {
        return $this->belongsTo(Thread::class);
    }
}
