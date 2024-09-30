<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'label',
        'value',
        'options',
        'type',
        'points',
        'quiz_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'options' => 'collection',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the quiz that owns the question.
     * 
     * @return BelongsTo - The quiz that owns the question.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the answers for the question.
     * 
     * @return HasMany - The answers for the question.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function getAnswerAttribute(): Answer
    {
        return $this->answers()->where('user_id', auth()->id())->first();
    }
}
