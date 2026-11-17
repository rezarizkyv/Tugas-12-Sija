<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\ExamSession;
use App\Models\ExamViolation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UjianController extends Controller
{
    // ─────────────────────────────────────────────────────────────────
    // HALAMAN SISWA
    // ─────────────────────────────────────────────────────────────────

    /**
     * Halaman daftar ujian (siswa)
     * Halaman daftar ujian (siswa) / monitoring jika admin
     */
    public function index()
    {
        // Jika admin membuka menu CBT / Ujian Online, arahkan ke dashboard monitoring admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $exams = Quiz::with(['course', 'questions'])->get();
        return view('ujian', compact('exams'));
    }

    // ─────────────────────────────────────────────────────────────────
    // LOG EVENT (START / GENERIC)
    // ─────────────────────────────────────────────────────────────────

    /**
     * POST /ujian/{id}/log-event
     * Mencatat event "start" atau event generik ke exam_sessions
     */
    public function logEvent(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'event_type' => 'required|string',
                'details'    => 'nullable|string',
            ]);

            if ($validated['event_type'] === 'start') {
                // Cari sesi aktif yang belum selesai
                $existing = ExamSession::where('quiz_id', $id)
                    ->where('user_id', Auth::id())
                    ->where('status', 'in_progress')
                    ->latest()
                    ->first();

                if (!$existing) {
                    $quiz = Quiz::findOrFail($id);
                    ExamSession::create([
                        'quiz_id'         => $id,
                        'user_id'         => Auth::id(),
                        'status'          => 'in_progress',
                        'total_questions' => $quiz->questions()->count(),
                        'started_at'      => now(),
                        'ip_address'      => $request->ip(),
                        'user_agent'      => $request->userAgent(),
                    ]);
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error logging exam event', ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // RECORD VIOLATION
    // ─────────────────────────────────────────────────────────────────

    /**
     * POST /ujian/{id}/violation
     * Mencatat pelanggaran ke exam_violations
     */
    public function recordViolation(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'quiz_id'        => 'required|exists:quizzes,id',
                'violation_type' => 'required|string',
                'warning_count'  => 'required|integer|min:1|max:3',
            ]);

            $violation = ExamViolation::create([
                'quiz_id'        => $validated['quiz_id'],
                'student_id'     => Auth::id(),
                'violation_type' => $validated['violation_type'],
                'warning_count'  => $validated['warning_count'],
                'ip_address'     => $request->ip(),
                'user_agent'     => $request->userAgent(),
                'recorded_at'    => now(),
            ]);

            // Update violation_count di exam_sessions
            ExamSession::where('quiz_id', $validated['quiz_id'])
                ->where('user_id', Auth::id())
                ->where('status', 'in_progress')
                ->update(['violation_count' => $validated['warning_count']]);

            Log::warning('Exam Violation Recorded', [
                'quiz_id'        => $validated['quiz_id'],
                'student_id'     => Auth::id(),
                'violation_type' => $validated['violation_type'],
                'warning_count'  => $validated['warning_count'],
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pelanggaran dicatat',
                'locked'  => $validated['warning_count'] >= 3,
            ]);
        } catch (\Exception $e) {
            Log::error('Error recording violation', ['error' => $e->getMessage()]);
            return response()->json(['success' => false], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // SUBMIT EXAM
    // ─────────────────────────────────────────────────────────────────

    /**
     * POST /ujian/{id}/submit
     * Menyimpan jawaban & menghitung nilai
     */
    public function submitExam(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'quiz_id'         => 'required|exists:quizzes,id',
                'answers'         => 'nullable|array',
                'submit_reason'   => 'nullable|string',
                'violation_count' => 'nullable|integer',
            ]);

            $answers       = $validated['answers'] ?? [];
            $submitReason  = $validated['submit_reason'] ?? 'manual';
            $violationCount = $validated['violation_count'] ?? 0;

            // Hitung nilai
            $quiz      = Quiz::with('questions')->findOrFail($id);
            $questions = $quiz->questions;
            $correct   = 0;

            foreach ($questions as $index => $question) {
                $givenAnswer = $answers[$index] ?? null;
                if ($givenAnswer && strtoupper($givenAnswer) === strtoupper($question->correct_answer ?? '')) {
                    $correct++;
                }
            }

            $totalQ = $questions->count();
            $score  = $totalQ > 0 ? round(($correct / $totalQ) * 100, 2) : 0;

            // Tentukan status
            $status = match(true) {
                str_contains($submitReason, 'violation') => 'auto_submitted',
                str_contains($submitReason, 'timeout')   => 'timeout',
                default                                   => 'completed',
            };

            // Cari & update sesi aktif, atau buat baru
            $session = ExamSession::where('quiz_id', $id)
                ->where('user_id', Auth::id())
                ->where('status', 'in_progress')
                ->latest()
                ->first();

            if ($session) {
                $session->update([
                    'status'          => $status,
                    'answers'         => $answers,
                    'score'           => $score,
                    'correct_count'   => $correct,
                    'total_questions' => $totalQ,
                    'violation_count' => $violationCount,
                    'submitted_at'    => now(),
                    'submit_reason'   => $submitReason,
                ]);
            } else {
                ExamSession::create([
                    'quiz_id'         => $id,
                    'user_id'         => Auth::id(),
                    'status'          => $status,
                    'answers'         => $answers,
                    'score'           => $score,
                    'correct_count'   => $correct,
                    'total_questions' => $totalQ,
                    'violation_count' => $violationCount,
                    'started_at'      => now(),
                    'submitted_at'    => now(),
                    'submit_reason'   => $submitReason,
                    'ip_address'      => $request->ip(),
                    'user_agent'      => $request->userAgent(),
                ]);
            }

            Log::info('Exam Submitted', [
                'quiz_id'    => $id,
                'student_id' => Auth::id(),
                'score'      => $score,
                'reason'     => $submitReason,
            ]);

            return response()->json([
                'success'    => true,
                'message'    => 'Ujian berhasil dikumpulkan',
                'score'      => $score,
                'correct'    => $correct,
                'total'      => $totalQ,
            ]);
        } catch (\Exception $e) {
            Log::error('Error submitting exam', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // ADMIN API — MONITORING
    // ─────────────────────────────────────────────────────────────────

    /**
     * GET /admin/cbt/monitoring
     * Data monitoring untuk dashboard admin (JSON, dipakai polling)
     */
    public function adminMonitoring(Request $request)
    {
        // Pastikan hanya admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $quizId  = $request->query('quiz_id');
        $kelas   = $request->query('kelas');
        $search  = $request->query('search');

        $sessions = ExamSession::with(['user', 'quiz.course'])
            ->when($quizId, fn($q) => $q->where('quiz_id', $quizId))
            ->when($kelas,  fn($q) => $q->whereHas('user', fn($u) => $u->where('kelas', $kelas)))
            ->when($search, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")))
            ->orderByDesc('started_at')
            ->get()
            ->map(function ($session) {
                // Ambil log pelanggaran siswa ini di ujian ini
                $violations = ExamViolation::where('quiz_id', $session->quiz_id)
                    ->where('student_id', $session->user_id)
                    ->orderBy('recorded_at')
                    ->get()
                    ->map(fn($v) => [
                        'type'         => $v->violation_type,
                        'warning_count'=> $v->warning_count,
                        'recorded_at'  => $v->recorded_at?->format('H:i:s'),
                    ]);

                return [
                    'id'              => $session->id,
                    'student_name'    => $session->user?->name ?? '-',
                    'student_kelas'   => $session->user?->kelas ?? '-',
                    'exam_title'      => $session->quiz?->title ?? '-',
                    'exam_code'       => $session->quiz?->code ?? '-',
                    'status'          => $session->status,
                    'status_label'    => $session->status_label,
                    'status_color'    => $session->status_color,
                    'violation_count' => $session->violation_count,
                    'score'           => $session->score,
                    'started_at'      => $session->started_at?->format('H:i:s'),
                    'submitted_at'    => $session->submitted_at?->format('H:i:s'),
                    'submit_reason'   => $session->submit_reason,
                    'violations'      => $violations,
                ];
            });

        // Data filter: daftar ujian & kelas unik
        $quizList  = Quiz::select('id', 'title', 'code')->orderBy('title')->get();
        $kelasList = \App\Models\User::where('role', 'user')
            ->whereNotNull('kelas')
            ->distinct()
            ->pluck('kelas')
            ->sort()
            ->values();

        return response()->json([
            'sessions'  => $sessions,
            'quizList'  => $quizList,
            'kelasList' => $kelasList,
            'timestamp' => now()->format('H:i:s'),
        ]);
    }
}
