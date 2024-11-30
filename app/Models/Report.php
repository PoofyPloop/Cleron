<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'quiz_id',
        'status',
    ];

    /**
     * Get the user that owns the Report
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that owns the Report
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
