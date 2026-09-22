<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            [
                'major' => 'rpl',
                'code' => 'RPL-XII-WEB',
                'title' => 'Pemrograman Web & Perangkat Bergerak',
                'teacher' => 'Bpk. Ahmad Fauzi, S.Kom',
                'modules_count' => 12,
                'assignments_count' => 4,
                'progress' => 85,
                'icon' => 'code',
                'color' => 'from-blue-600 to-indigo-700',
            ],
            [
                'major' => 'rpl',
                'code' => 'RPL-XII-BD',
                'title' => 'Basis Data & SQL Optimization',
                'teacher' => 'Ibu Sita Nurhaliza, M.T',
                'modules_count' => 8,
                'assignments_count' => 2,
                'progress' => 90,
                'icon' => 'database',
                'color' => 'from-cyan-600 to-blue-700',
            ],
            [
                'major' => 'tkj',
                'code' => 'TKJ-XII-NET',
                'title' => 'Administrasi Infrastruktur Jaringan',
                'teacher' => 'Bpk. Hendra Wijaya, S.T',
                'modules_count' => 10,
                'assignments_count' => 3,
                'progress' => 70,
                'icon' => 'network-wired',
                'color' => 'from-purple-600 to-indigo-800',
            ],
            [
                'major' => 'dkv',
                'code' => 'DKV-XII-UIUX',
                'title' => 'Desain UI/UX & Interactive Prototyping',
                'teacher' => 'Ibu Rina Kartika, S.Ds',
                'modules_count' => 9,
                'assignments_count' => 3,
                'progress' => 60,
                'icon' => 'palette',
                'color' => 'from-pink-600 to-rose-700',
            ],
            [
                'major' => 'tkr',
                'code' => 'TKR-XII-ENG',
                'title' => 'Pemeliharaan Engine Kendaraan Ringan (EFI)',
                'teacher' => 'Bpk. Supriadi, M.Pd',
                'modules_count' => 7,
                'assignments_count' => 2,
                'progress' => 75,
                'icon' => 'wrench',
                'color' => 'from-amber-600 to-orange-700',
            ],
        ];

        foreach ($courses as $c) {
            $course = Course::create($c);

            // Buat ujian untuk setiap course
            $quiz = Quiz::create([
                'course_id' => $course->id,
                'code' => 'UJIAN-' . $course->code,
                'title' => 'Ujian Akhir: ' . $course->title,
                'description' => 'Ujian akhir semester untuk mengevaluasi pemahaman materi.',
                'duration_minutes' => 60,
                'status' => 'active',
                'is_secure_mode' => true,
            ]);

            // Tambahkan contoh soal ke setiap ujian
            for ($i = 1; $i <= 3; $i++) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => 'Contoh soal ' . $i . ' untuk pelajaran ' . $course->title . '...',
                    'options' => json_encode([
                        'A' => 'Pilihan Jawaban A',
                        'B' => 'Pilihan Jawaban B',
                        'C' => 'Pilihan Jawaban C',
                        'D' => 'Pilihan Jawaban D',
                    ]),
                    'correct_option' => 'A',
                    'points' => 10,
                ]);
            }

            // Tambahkan Modul/Materi Pembelajaran dummy
            \App\Models\Module::create([
                'course_id' => $course->id,
                'title' => 'Materi Bab 1: Pengantar ' . $course->title,
                'description' => 'Pendahuluan dan konsep dasar dari ' . $course->title,
                'type' => 'document',
                'content_url' => '#',
                'order_index' => 1,
            ]);

            \App\Models\Module::create([
                'course_id' => $course->id,
                'title' => 'Video Penjelasan: ' . $course->title,
                'description' => 'Penjelasan komprehensif melalui video pembelajaran.',
                'type' => 'video',
                'content_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ', // Placeholder link
                'order_index' => 2,
            ]);
        }
    }
}
