<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamViolation extends Model
{
    protected $fillable = [
        'quiz_id',
        'student_id',
        'violation_type',
        'warning_count',
        'ip_address',
        'user_agent',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the quiz associated with this violation
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Scope: Get violations from a specific quiz
     */
    public function scopeForQuiz($query, $quizId)
    {
        return $query->where('quiz_id', $quizId);
    }

    /**
     * Scope: Get violations for a specific student
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    /**
     * Scope: Get critical violations (warning 3 = kicked out)
     */
    public function scopeCritical($query)
    {
        return $query->where('warning_count', '>=', 3);
    }

    /**
     * Scope: Get violations from last N minutes
     */
    public function scopeRecent($query, $minutes = 60)
    {
        return $query->where('recorded_at', '>=', now()->subMinutes($minutes));
    }
}
