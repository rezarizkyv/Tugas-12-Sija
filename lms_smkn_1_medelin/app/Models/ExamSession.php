<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamSession extends Model
{
    protected $fillable = [
        'quiz_id',
        'user_id',
        'status',
        'answers',
        'score',
        'correct_count',
        'total_questions',
        'violation_count',
        'started_at',
        'submitted_at',
        'ip_address',
        'user_agent',
        'submit_reason',
    ];

    protected $casts = [
        'answers'      => 'array',
        'started_at'   => 'datetime',
        'submitted_at' => 'datetime',
    ];

    // ─── Relationships ─────────────────────────────────────────────────

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function violations(): HasMany
    {
        return $this->hasMany(ExamViolation::class, 'quiz_id', 'quiz_id')
                    ->where('student_id', $this->user_id);
    }

    // ─── Scopes ────────────────────────────────────────────────────────

    public function scopeForQuiz($query, $quizId)
    {
        return $query->where('quiz_id', $quizId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // ─── Helpers ───────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'in_progress'   => 'Sedang Mengerjakan',
            'completed'     => 'Selesai',
            'auto_submitted'=> 'Dikumpulkan Otomatis (Pelanggaran)',
            'timeout'       => 'Waktu Habis',
            default         => 'Tidak Diketahui',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'in_progress'   => 'blue',
            'completed'     => 'green',
            'auto_submitted'=> 'red',
            'timeout'       => 'amber',
            default         => 'slate',
        };
    }
}

