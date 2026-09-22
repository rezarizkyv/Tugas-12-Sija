<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Course;

class QuizSeeder extends Seeder
{
    public function run()
    {
        // Get all courses
        $courses = Course::all();

        foreach ($courses as $course) {
            // Create a quiz for each course
            $quiz = Quiz::create([
                'course_id' => $course->id,
                'code' => strtoupper($course->code) . '-QUIZ-01',
                'title' => 'Ujian ' . $course->title,
                'description' => 'Ujian untuk mata pelajaran ' . $course->title,
                'duration_minutes' => 45,
                'total_questions' => 10,
                'is_secure_mode' => true,
                'randomize_questions' => false,
                'randomize_options' => false,
                'status' => 'active',
            ]);

            // Create 10 questions based on course type
            $questions = $this->getQuestionsForCourse($course->title, $course->code);

            foreach ($questions as $questionData) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['text'],
                    'options' => $questionData['options'],
                    'correct_option' => $questionData['correct'],
                    'points' => 10,
                ]);
            }

            echo "✓ Quiz created for {$course->title} with 10 questions\n";
        }
    }

    private function getQuestionsForCourse($courseName, $courseCode)
    {
        $courseName = strtolower($courseName);

        // Web Programming & Perangkat Bergerak Questions
        if (strpos($courseName, 'web') !== false || strpos($courseName, 'program') !== false || strpos($courseName, 'perangkat') !== false) {
            return [
                [
                    'text' => 'Apa kepanjangan dari HTML dan apa fungsi utamanya?',
                    'options' => ['HyperText Markup Language - styling halaman', 'HyperText Markup Language - struktur konten', 'High Tech Modern Language - interaktivitas', 'Hyperlinks Text Markup Layer - database'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Dalam pengembangan web responsif, breakpoint apa yang paling umum untuk tablet?',
                    'options' => ['640px', '768px-1024px', '1920px', '480px'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Framework JavaScript mana yang paling banyak digunakan untuk SPA (Single Page Application)?',
                    'options' => ['jQuery', 'React, Vue, atau Angular', 'Bootstrap', 'Tailwind CSS'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa perbedaan utama antara var, let, dan const dalam JavaScript?',
                    'options' => ['Tidak ada perbedaan', 'let dan const memiliki block scope, var memiliki function scope', 'const tidak bisa diubah, var bisa', 'Semuanya benar'],
                    'correct' => 'D',
                ],
                [
                    'text' => 'Protocol apa yang digunakan untuk komunikasi real-time pada web?',
                    'options' => ['FTP', 'WebSocket', 'SMTP', 'POP3'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Dalam konteks mobile development, apa perbedaan Native App dan Hybrid App?',
                    'options' => ['Native menggunakan kode native, Hybrid menggunakan web technologies', 'Native lebih cepat tapi Hybrid lebih murah', 'Keduanya sama saja', 'Native tidak bisa offline, Hybrid bisa'],
                    'correct' => 'A',
                ],
                [
                    'text' => 'Apa fungsi dari localStorage dalam JavaScript?',
                    'options' => ['Menyimpan data sementara di server', 'Menyimpan data di browser secara persisten', 'Mengakses file lokal komputer', 'Mengelola folder di hard drive'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Bagaimana cara mengoptimasi performa website?',
                    'options' => ['Hanya dengan CSS', 'Minify JS/CSS, image compression, lazy loading, caching', 'Menggunakan banyak animasi', 'Menambah ukuran file'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa itu CORS dan mengapa penting dalam web development?',
                    'options' => ['Cross-Origin Resource Sharing - aturan keamanan browser', 'Core Origin Routing System - routing protocol', 'Cascade Order Resource Storage - penyimpanan data', 'Custom Origin Response Security - protokol keamanan'],
                    'correct' => 'A',
                ],
                [
                    'text' => 'Framework mobile cross-platform apa yang menggunakan React Native dan Flutter?',
                    'options' => ['Keduanya untuk membuat native app dengan JavaScript/Dart', 'React Native untuk iOS saja, Flutter untuk Android', 'Flutter lebih baik dari React Native', 'Keduanya untuk web saja'],
                    'correct' => 'A',
                ],
            ];
        }

        // Basis Data & SQL Optimization Questions
        elseif (strpos($courseName, 'database') !== false || strpos($courseName, 'sql') !== false || strpos($courseName, 'basis data') !== false) {
            return [
                [
                    'text' => 'Apa itu database relasional dan karakteristik utamanya?',
                    'options' => ['Database dengan tabel yang tidak berhubungan', 'Database dengan tabel, primary key, foreign key, dan normalisasi', 'Database cloud yang skalabel', 'Database untuk menyimpan file multimedia'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Normalisasi database bertujuan untuk apa?',
                    'options' => ['Mempercepat query execution', 'Mengurangi redundansi data dan anomali', 'Menambah kapasitas storage', 'Mengenkripsi data sensitif'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Perintah SQL mana yang digunakan untuk membaca data dari tabel?',
                    'options' => ['DELETE', 'UPDATE', 'SELECT', 'INSERT'],
                    'correct' => 'C',
                ],
                [
                    'text' => 'Apa fungsi PRIMARY KEY dalam desain database?',
                    'options' => ['Mempercepat pencarian row', 'Mengidentifikasi setiap record secara unik', 'Menghubungkan dua tabel', 'Membuat backup otomatis'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Tipe JOIN mana yang mengembalikan semua baris dari tabel kiri ditambah data yang cocok dari tabel kanan?',
                    'options' => ['INNER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'FULL OUTER JOIN'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa itu Foreign Key dan fungsinya dalam relasi antar tabel?',
                    'options' => ['Kunci untuk mengakses database', 'Referensi ke primary key tabel lain untuk menjaga integritas data', 'Kolom dengan nilai unik', 'Password untuk login database'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Perintah mana untuk menghapus semua data di tabel tapi mempertahankan struktur tabel?',
                    'options' => ['DELETE FROM users', 'DROP TABLE users', 'TRUNCATE users', 'PURGE users'],
                    'correct' => 'C',
                ],
                [
                    'text' => 'Apa itu Index dalam database dan keuntaannya?',
                    'options' => ['Tabel backup', 'Struktur data untuk mempercepat pencarian data', 'Kolom dengan nilai unik', 'Jenis database NoSQL'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa itu Transaction dalam database dan ACID properties?',
                    'options' => ['Pengiriman uang antar rekening', 'Serangkaian operasi yang atomik, konsisten, isolated, dan durable', 'Proses backup otomatis', 'Update password user'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Query optimization untuk performa database termasuk?',
                    'options' => ['Membuat banyak index pada semua kolom', 'SELECT * tanpa WHERE clause', 'Menggunakan prepared statements, proper indexing, dan query analysis', 'Tidak ada cara mengoptimasi query'],
                    'correct' => 'C',
                ],
            ];
        }

        // Jaringan Komputer & Networking Questions
        elseif (strpos($courseName, 'jaringan') !== false || strpos($courseName, 'network') !== false) {
            return [
                [
                    'text' => 'Apa itu TCP/IP dan layer apa yang ada dalam model OSI?',
                    'options' => ['Hanya satu layer', 'Protocol komunikasi internet dengan 4-5 layer (Application, Transport, Internet, Link)', 'Jenis router jaringan', 'Aplikasi server web'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Berapa bit dalam 1 byte dan berapa byte dalam 1 kilobyte?',
                    'options' => ['4 bit, 512 byte', '8 bit, 1024 byte', '16 bit, 2048 byte', '32 bit, 4096 byte'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa fungsi gateway dalam jaringan komputer?',
                    'options' => ['Menyimpan data backup', 'Menghubungkan jaringan yang berbeda protocol/teknologi', 'Mengamankan password user', 'Mempercepat koneksi internet'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Topologi jaringan mana yang paling aman namun paling mahal dan kompleks?',
                    'options' => ['Bus topology', 'Star topology', 'Ring topology', 'Mesh topology'],
                    'correct' => 'D',
                ],
                [
                    'text' => 'Apa itu DNS dan fungsinya dalam internet?',
                    'options' => ['Distributed Network System - penyimpanan file', 'Domain Name System - menerjemahkan nama domain ke IP address', 'Data Network Security - enkripsi data', 'Dynamic Network Setup - konfigurasi jaringan'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Port berapa yang digunakan untuk HTTP dan HTTPS?',
                    'options' => ['21 dan 22', '80 dan 443', '3306 dan 5432', '8000 dan 9000'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa fungsi firewall dalam keamanan jaringan?',
                    'options' => ['Mempercepat koneksi internet', 'Memfilter dan mengontrol traffic jaringan berdasarkan rules', 'Menambah bandwidth jaringan', 'Mengenkripsi semua password'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'IPv4 memiliki berapa bit address dan berapa maksimal host yang bisa dialamatkan?',
                    'options' => ['16 bit, 65,536 host', '32 bit, 4.3 miliar host', '64 bit, unlimited', '128 bit, 340 undecillion host'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa itu DHCP dan apa fungsinya dalam jaringan?',
                    'options' => ['Database untuk menyimpan IP', 'Dynamic Host Configuration Protocol - pemberian IP otomatis ke device', 'Direct Hosting Control Protocol', 'Digital Host Connection Protocol'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Kecepatan 1 Gbps sama dengan berapa Mbps dan apa perbedaan dengan kecepatan 1 GBps?',
                    'options' => ['100 Mbps', '1000 Mbps (Gbps 8x lebih lambat dari GBps)', '10,000 Mbps', 'Keduanya sama'],
                    'correct' => 'B',
                ],
            ];
        }

        // Default questions (General IT Fundamentals)
        else {
            return [
                [
                    'text' => 'Apa itu sistem operasi dan apa fungsi utamanya dalam komputer?',
                    'options' => ['Program aplikasi untuk kerja kantoran', 'Software yang mengelola hardware dan menyediakan interface untuk aplikasi', 'Perangkat keras komputer', 'Browser web untuk browsing internet'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Sistem operasi apa yang paling banyak digunakan di dunia untuk desktop/laptop?',
                    'options' => ['Linux', 'Windows', 'macOS', 'Unix'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa itu RAM dan apa perbedaannya dengan SSD/HDD?',
                    'options' => ['RAM adalah penyimpanan permanen, SSD cepat tapi temporer', 'RAM adalah memori cepat temporer untuk proses, SSD/HDD adalah penyimpanan permanen', 'Keduanya sama fungsinya', 'RAM untuk gaming, SSD untuk kerja'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Satuan ukuran data apa yang paling besar dari pilihan berikut?',
                    'options' => ['Megabyte (MB)', 'Gigabyte (GB)', 'Terabyte (TB)', 'Petabyte (PB)'],
                    'correct' => 'D',
                ],
                [
                    'text' => 'Apa itu cloud computing dan berikan contohnya?',
                    'options' => ['Penyimpanan fisik di server lokal', 'Layanan komputasi dan penyimpanan data melalui internet seperti Google Drive, AWS, Azure', 'Teknologi untuk membuat website', 'Aplikasi offline untuk produktivitas'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Siapa yang dikenal sebagai penemu internet/World Wide Web?',
                    'options' => ['Steve Jobs', 'Bill Gates', 'Tim Berners-Lee', 'Linus Torvalds'],
                    'correct' => 'C',
                ],
                [
                    'text' => 'Apa kepanjangan dari AI dan apa contoh aplikasinya?',
                    'options' => ['Artificial Integration - integrasi sistem', 'Artificial Intelligence - ChatGPT, face recognition, rekomendasi', 'Advanced Internet - jaringan terbaru', 'Automated Interface - UI otomatis'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa itu cybersecurity dan mengapa penting?',
                    'options' => ['Keamanan fisik untuk data center', 'Perlindungan sistem komputer dari serangan digital dan pencurian data', 'Backup data otomatis', 'Update software secara berkala'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Apa karakteristik password yang kuat dan aman?',
                    'options' => ['Panjang dan mudah diingat', 'Kombinasi huruf besar, huruf kecil, angka, dan simbol dengan panjang minimal 8 karakter', 'Menggunakan nama dan tanggal lahir', 'Sama untuk semua akun supaya tidak lupa'],
                    'correct' => 'B',
                ],
                [
                    'text' => 'Aplikasi apa yang biasa digunakan untuk membuat presentasi profesional?',
                    'options' => ['Microsoft Word', 'Microsoft Excel', 'Microsoft PowerPoint', 'Microsoft Access'],
                    'correct' => 'C',
                ],
            ];
        }
    }
}
