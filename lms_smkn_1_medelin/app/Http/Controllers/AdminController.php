<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use App\Models\ExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Dashboard Admin — statistik & manajemen user.
     */
    public function dashboard()
    {
        $stats = [
            'total_users'  => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_all'    => User::count(),
        ];

        $users = User::where('role', 'user')->latest()->get();

        // Simulasi data tugas yang belum diunggah oleh user biasa
        $missingTasks = [
            (object)['student' => 'Budi Santoso', 'course' => 'Pemrograman Web', 'task' => 'Tugas 1: HTML Dasar'],
            (object)['student' => 'Budi Santoso', 'course' => 'Basis Data', 'task' => 'Tugas 2: Normalisasi Tabel'],
            (object)['student' => 'Siti Aminah', 'course' => 'Desain UI/UX', 'task' => 'Tugas Akhir Prototype'],
        ];

        // Data CBT monitoring ringkasan
        $cbtStats = [
            'total_sessions'    => ExamSession::count(),
            'in_progress'       => ExamSession::where('status', 'in_progress')->count(),
            'auto_submitted'    => ExamSession::where('status', 'auto_submitted')->count(),
            'completed'         => ExamSession::whereIn('status', ['completed', 'timeout'])->count(),
            'active_quizzes'    => Quiz::where('status', 'active')->count(),
        ];

        return view('admin.dashboard', compact('stats', 'users', 'missingTasks', 'cbtStats'));
    }
}
