<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\ExamViolation;
use Illuminate\Support\Facades\Log;

class UjianController extends Controller
{
    public function index()
    {
        // Load exams with their questions and course data
        $exams = Quiz::with(['course', 'questions'])->get();

        return view('ujian', compact('exams'));
    }

    /**
     * Record a violation during exam (tab switch, blur, etc)
     */
    public function recordViolation(Request $request)
    {
        try {
            $validated = $request->validate([
                'quiz_id' => 'required|exists:quizzes,id',
                'violation_type' => 'required|string',
                'warning_count' => 'required|integer|min:1|max:3',
            ]);

            // Log the violation
            $violation = ExamViolation::create([
                'quiz_id' => $validated['quiz_id'],
                'student_id' => auth()->id() ?? null,
                'violation_type' => $validated['violation_type'],
                'warning_count' => $validated['warning_count'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Log::warning('Exam Violation Recorded', [
                'quiz_id' => $validated['quiz_id'],
                'student_id' => auth()->id(),
                'violation_type' => $validated['violation_type'],
                'warning_count' => $validated['warning_count'],
                'ip' => $request->ip(),
            ]);

            // If 3rd warning, mark student as locked
            if ($validated['warning_count'] >= 3) {
                $this->lockStudentFromExam($validated['quiz_id']);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pelanggaran dicatat dalam sistem',
                'locked' => $validated['warning_count'] >= 3,
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording exam violation', ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Submit exam with answers
     */
    public function submitExam(Request $request)
    {
        try {
            $validated = $request->validate([
                'quiz_id' => 'required|exists:quizzes,id',
                'answers' => 'nullable|array',
            ]);

            // Check if student is locked
            if ($this->isStudentLockedFromExam($validated['quiz_id'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda telah dikeluarkan dari ujian ini karena pelanggaran sistem keamanan',
                    'locked' => true,
                ], 403);
            }

            // TODO: Save exam submission to database
            // This would grade the answers and save results
            
            Log::info('Exam Submitted', [
                'quiz_id' => $validated['quiz_id'],
                'student_id' => auth()->id(),
                'answered_questions' => count($validated['answers'] ?? []),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Ujian berhasil dikumpulkan',
            ]);
        } catch (\Exception $e) {
            Log::error('Error submitting exam', ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }

    /**
     * Lock a student from accessing an exam after 3rd violation
     */
    private function lockStudentFromExam($quizId)
    {
        $quiz = Quiz::find($quizId);
        if (!$quiz) return;

        // Lock student by adding to locked_students list (if using JSON field)
        // Or create a separate exam_locks table
        // For now, log the lock event
        Log::alert('Student Locked From Exam', [
            'quiz_id' => $quizId,
            'student_id' => auth()->id(),
            'timestamp' => now(),
        ]);
    }

    /**
     * Check if student is locked from accessing an exam
     */
    private function isStudentLockedFromExam($quizId)
    {
        // Check if student has 3+ violations on this quiz
        $criticalViolations = ExamViolation::forQuiz($quizId)
            ->forStudent(auth()->id())
            ->critical()
            ->exists();

        return $criticalViolations;
    }

    /**
     * Get violation history for an exam (admin view)
     */
    public function getViolationHistory($quizId)
    {
        if (!auth()->user() || !auth()->user()->isAdmin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $violations = ExamViolation::forQuiz($quizId)
            ->orderBy('recorded_at', 'desc')
            ->get();

        return response()->json($violations);
    }
}
