<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $admins = User::where('role', 'admin')->latest()->get();

        // Simulasi data tugas yang belum diunggah oleh user biasa
        $missingTasks = [
            (object)['student' => 'Budi Santoso', 'course' => 'Pemrograman Web', 'task' => 'Tugas 1: HTML Dasar'],
            (object)['student' => 'Budi Santoso', 'course' => 'Basis Data', 'task' => 'Tugas 2: Normalisasi Tabel'],
            (object)['student' => 'Siti Aminah', 'course' => 'Desain UI/UX', 'task' => 'Tugas Akhir Prototype'],
        ];

        return view('admin.dashboard', compact('stats', 'users', 'admins', 'missingTasks'));
    }
}
