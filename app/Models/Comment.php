<?php

namespace App\Models;


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
