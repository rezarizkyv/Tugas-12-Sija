<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = [
            'name' => 'Siswa Medelin',
            'nisn' => '0054891203',
            'class' => 'XII RPL',
            'major' => 'Rekayasa Perangkat Lunak',
            'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=MedelinStudent',
        ];

        $stats = [
            'attendance_rate' => 98.0,
            'pending_tasks' => 3,
            'upcoming_exams' => 1,
            'gpa' => 88.5,
        ];

        $activities = [
            [
                'title' => 'Tugas Pemrograman Web & Perangkat Bergerak',
                'teacher' => 'Bpk. Ahmad Fauzi, S.Kom',
                'time' => '10 menit yang lalu',
                'type' => 'assignment',
                'badge' => 'Tugas Baru',
            ],
            [
                'title' => 'Jadwal Penilaian Tengah Semester (PTS) Genap 2026 Dirilis',
                'teacher' => 'Kurikulum SMKN 1 Medelin',
                'time' => '1 jam yang lalu',
                'type' => 'announcement',
                'badge' => 'Pengumuman',
            ],
            [
                'title' => 'Presensi Harian Berhasil Terkonfirmasi Via GPS Radius Sekolah',
                'teacher' => 'Sistem Presensi Geofence',
                'time' => '07:15 WIB',
                'type' => 'attendance',
                'badge' => 'Presensi Valid',
            ],
            [
                'title' => 'Materi Pembelajaran Basis Data: Query JOIN & Optimization (PDF)',
                'teacher' => 'Ibu Sita Nurhaliza, M.T',
                'time' => 'Kemarin',
                'type' => 'elearning',
                'badge' => 'Modul Baru',
            ],
        ];

        return view('dashboard', compact('student', 'stats', 'activities'));
    }
}
