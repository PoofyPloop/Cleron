<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug'
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
