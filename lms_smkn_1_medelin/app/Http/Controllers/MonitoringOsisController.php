<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonitoringOsisController extends Controller
{
    public function index()
    {
        $classMonitoring = [
            'class_name' => 'XII RPL 1',
            'homeroom_teacher' => 'Ibu Sita Nurhaliza, M.T',
            'total_students' => 36,
            'present' => 34,
            'sick' => 1,
            'permitted' => 1,
            'absent' => 0,
            'attendance_rate' => 94.4,
            'status' => 'Kegiatan Belajar Mengajar Berlangsung Kondusif',
        ];

        $candidates = [
            [
                'id' => 1,
                'number' => 1,
                'leader' => 'Muhammad Fathan (XI RPL 1)',
                'vice' => 'Nabila Putri (XI DKV 2)',
                'tagline' => 'Digitalisasi Ekstrakurikuler & Pembentukan Mentoring Karir',
                'vision' => 'Mewujudkan OSIS SMKN 1 Medelin yang inovatif, berteknologi tinggi, serta adaptif terhadap kebutuhan dunia kerja.',
                'mission' => [
                    'Mengembangkan platform event sekolah berbasis digital & paperless.',
                    'Menyelenggarakan workshop bootcamp coding & UI/UX antar jurusan.',
                    'Menguatkan sinergi antara organisasi siswa dan kemitraan industri.',
                ],
                'votes' => 482,
                'percentage' => 45.2,
                'color' => 'from-blue-500 to-indigo-600',
            ],
            [
                'id' => 2,
                'number' => 2,
                'leader' => 'Bintang Ramadhan (XI TKJ 3)',
                'vice' => 'Zahra Annisa (XI TKT 1)',
                'tagline' => 'Solidaritas Kemanusiaan & Penghijauan Kampus Medelin',
                'vision' => 'Menjadikan SMKN 1 Medelin sebagai sekolah ramah lingkungan, berprestasi di tingkat nasional, dan menjunjung tinggi solidaritas.',
                'mission' => [
                    'Membangun bank sampah digital dan gerakan Green Medelin Campus.',
                    'Mengadakan kejuaraan e-sports dan olahraga antar SMK se-Kabupaten.',
                    'Meningkatkan fasilitas ruang kreativitas siswa.',
                ],
                'votes' => 420,
                'percentage' => 39.4,
                'color' => 'from-amber-500 to-orange-600',
            ],
            [
                'id' => 3,
                'number' => 3,
                'leader' => 'Kevin Sanjaya (XI TKR 2)',
                'vice' => 'Aulia Rahma (XI RPL 2)',
                'tagline' => 'Kewirausahaan Siswa & Hubungan Alumni Terpadu',
                'vision' => 'Menciptakan ekosistem wirausaha muda di lingkungan sekolah yang mandiri dan berdaya saing tinggi.',
                'mission' => [
                    'Membuka unit usaha Kantin Kejujuran Digital berbasis QRIS.',
                    'Membuat forum alumni untuk penyaluran magang & kerja.',
                    'Mengadakan expo produk karya siswa per semester.',
                ],
                'votes' => 164,
                'percentage' => 15.4,
                'color' => 'from-emerald-500 to-teal-600',
            ],
        ];

        $hasVoted = false; // Dummy state for election token check

        return view('monitoring-osis', compact('classMonitoring', 'candidates', 'hasVoted'));
    }
}
