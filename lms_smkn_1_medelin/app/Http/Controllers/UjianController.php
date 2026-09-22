<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function index()
    {
        $exams = [
            [
                'id' => 101,
                'code' => 'PTS-2026-WEB',
                'title' => 'Penilaian Tengah Semester (PTS) - Pemrograman Web & Mobile',
                'subject' => 'Pemrograman Web',
                'duration' => 60,
                'questions_count' => 20,
                'start_time' => '08:00 WIB',
                'end_time' => '09:00 WIB',
                'is_secure' => true,
                'status' => 'active', // active, upcoming, completed
            ],
            [
                'id' => 102,
                'code' => 'QUIZ-BD-02',
                'title' => 'Kuis Harian 2 - Normalisasi & Indexing Basis Data',
                'subject' => 'Basis Data',
                'duration' => 30,
                'questions_count' => 10,
                'start_time' => '10:30 WIB',
                'end_time' => '11:00 WIB',
                'is_secure' => true,
                'status' => 'upcoming',
            ],
            [
                'id' => 103,
                'code' => 'TRYOUT-UKK-RPL',
                'title' => 'Tryout Uji Kompetensi Keahlian (UKK) RPL 2026',
                'subject' => 'Kejuruan RPL',
                'duration' => 120,
                'questions_count' => 40,
                'start_time' => 'Selesai 10 Sep',
                'end_time' => '10 Sep 2026',
                'is_secure' => true,
                'status' => 'completed',
                'score' => 92.5,
            ],
        ];

        // Sample CBT Exam Simulator Data
        $activeExam = [
            'id' => 101,
            'code' => 'PTS-2026-WEB',
            'title' => 'Penilaian Tengah Semester (PTS) - Pemrograman Web & Mobile',
            'subject' => 'Pemrograman Web',
            'time_remaining_seconds' => 2840, // 47 minutes left
            'questions' => [
                [
                    'id' => 1,
                    'number' => 1,
                    'text' => 'Di bawah ini yang merupakan keuntungan utama dari penggunaan arsitektur MVC (Model-View-Controller) dalam pengembangan aplikasi web modern dengan Laravel adalah...',
                    'options' => [
                        'A' => 'Memisahkan logika bisnis, tampilan visual, dan penanganan request sehingga kode lebih terstruktur dan mudah di-maintain.',
                        'B' => 'Mempercepat kecepatan koneksi internet pengguna secara otomatis saat mengakses server.',
                        'C' => 'Menghilangkan kebutuhan akan basis data relasional MySQL.',
                        'D' => 'Membuat kode HTML tidak perlu dikompilasi oleh web browser.',
                    ],
                    'selected' => 'A',
                    'is_doubtful' => false,
                ],
                [
                    'id' => 2,
                    'number' => 2,
                    'text' => 'Perintah Artisan yang digunakan untuk menjalankan migrasi database serta mengisikan data dummy awal (seeding) secara bersamaan di Laravel adalah...',
                    'options' => [
                        'A' => 'php artisan migrate:fresh --seed',
                        'B' => 'php artisan make:migration --all',
                        'C' => 'php artisan db:start --force',
                        'D' => 'php artisan run:seeder',
                    ],
                    'selected' => null,
                    'is_doubtful' => true,
                ],
                [
                    'id' => 3,
                    'number' => 3,
                    'text' => 'Fungsi utama dari penggunaan token CSRF (@csrf) pada form HTML di Laravel adalah untuk...',
                    'options' => [
                        'A' => 'Mencegah serangan Cross-Site Request Forgery dengan memverifikasi bahwa request berasal dari aplikasi resmi.',
                        'B' => 'Mempercepat kompresi gambar yang diunggah oleh pengguna.',
                        'C' => 'Menyimpan data password pengguna dalam bentuk plain text.',
                        'D' => 'Mengubah halaman web menjadi aplikasi native Android.',
                    ],
                    'selected' => 'A',
                    'is_doubtful' => false,
                ],
            ]
        ];

        return view('ujian', compact('exams', 'activeExam'));
    }
}
