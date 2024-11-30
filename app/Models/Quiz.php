<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'started_at',
        'ended_at',
        'user_id',
        'category_id',
        'subject_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user that owns the Quiz
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the Quiz
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all of the questions for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the subject that owns the Quiz
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all of the reports for the Quiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    /**
     * Get all of the results for the Quiz for a specific user
     * 
     * @return \Illuminate\Database\Eloquent\Collection - The results for the user
     */
    public function results(): \Illuminate\Database\Eloquent\Collection
    {
        $user = auth()->user();

        return $this->questions->load([
            'answers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }
        ]);
    }

    /**
     * Get all of the answers for the Quiz
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function answers(): HasManyThrough
    {
        return $this->hasManyThrough(Answer::class, Question::class);
    }

    /**
     * Get the score for the Quiz
     * 
     * @return int - The score of the quiz
     */
    public function getScoreAttribute(): int
    {
        $user = auth()->user();
        return $this->answers()->where('user_id', $user->id)->sum('score');
    }

    /**
     * Get the correct answe for the Quiz
     * 
     * @return int - The correct answer for the quiz
     */
    // public function getAnswerAttribute()
    // {
    //     return $this->answers->firstWhere('user_id', auth()->id());
    // }


    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
