<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CbtExamApiController extends Controller
{
    /**
     * Log Anti-Cheat Violation during CBT Exam
     * POST /api/v1/quizzes/{id}/log-violation
     */
    public function logViolation(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'event_type' => 'required|string|in:blur_window,app_switch,device_change,screenshot_attempt',
            'details' => 'nullable|string',
        ]);

        // Simulated Exam Violation Logging
        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Pelanggaran keamanan ujian telah dicatat di server anti-cheat CBT.',
            'data' => [
                'quiz_id' => $id,
                'event_type' => $validated['event_type'],
                'timestamp' => now()->toIso8601String(),
                'warning_count' => 1,
                'max_allowed_warnings' => 3,
            ]
        ]);
    }

    /**
     * Submit CBT Exam Answers
     * POST /api/v1/quizzes/{id}/submit
     */
    public function submitExam(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Jawaban Ujian CBT Berhasil Terkirim & Ter-grading Otomatis.',
            'data' => [
                'quiz_id' => $id,
                'score' => 90.0,
                'total_questions' => count($validated['answers']),
                'correct_answers' => count($validated['answers']),
                'submitted_at' => now()->toIso8601String(),
            ]
        ]);
    }
}
