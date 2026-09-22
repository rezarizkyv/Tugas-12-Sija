<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'code',
        'title',
        'subject',
        'description',
        'duration_minutes',
        'start_time',
        'end_time',
        'total_questions',
        'is_secure_mode',
        'randomize_questions',
        'randomize_options',
        'status',
    ];

    protected $casts = [
        'is_secure_mode' => 'boolean',
        'randomize_questions' => 'boolean',
        'randomize_options' => 'boolean',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function examLogs(): HasMany
    {
        return $this->hasMany(ExamLog::class);
    }
}
