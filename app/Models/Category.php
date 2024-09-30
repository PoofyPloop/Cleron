<?php

namespace App\Models;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'subject_id'
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
