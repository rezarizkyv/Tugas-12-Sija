<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $currentDay = 'Selasa'; // Dummy active day

        $schedule = [
            'Senin' => [
                ['time' => '07:00 - 07:30', 'subject' => 'Upacara Bendera & Apel Pagi', 'teacher' => 'Tim Kesiswaan', 'room' => 'Lapangan Utama', 'is_break' => false],
                ['time' => '07:30 - 09:45', 'subject' => 'Pemrograman Berorientasi Objek', 'teacher' => 'Bpk. Rizky Ramadhan, S.Kom', 'room' => 'Lab RPL 1', 'is_break' => false],
                ['time' => '09:45 - 10:15', 'subject' => 'Istirahat Pertama', 'teacher' => '-', 'room' => 'Kantin / Area Sekolah', 'is_break' => true],
                ['time' => '10:15 - 12:15', 'subject' => 'Pemodelan Perangkat Lunak', 'teacher' => 'Ibu Sita Nurhaliza, M.T', 'room' => 'Lab RPL 1', 'is_break' => false],
                ['time' => '12:15 - 13:00', 'subject' => 'ISHOMA (Istirahat, Sholat, Makan)', 'teacher' => '-', 'room' => 'Masjid Sekolah', 'is_break' => true],
                ['time' => '13:00 - 15:30', 'subject' => 'Produk Kreatif & Kewirausahaan', 'teacher' => 'Bpk. Danang Wahyudi, S.E', 'room' => 'Ruang 12 RPL', 'is_break' => false],
            ],
            'Selasa' => [
                ['time' => '07:00 - 07:30', 'subject' => 'Literasi & Pembiasaan Karakter', 'teacher' => 'Wali Kelas XII RPL', 'room' => 'Ruang 12 RPL', 'is_break' => false],
                ['time' => '07:30 - 09:45', 'subject' => 'Pemrograman Web & Perangkat Bergerak', 'teacher' => 'Bpk. Ahmad Fauzi, S.Kom', 'room' => 'Lab RPL 2', 'is_break' => false, 'is_active' => true],
                ['time' => '09:45 - 10:15', 'subject' => 'Istirahat Pertama', 'teacher' => '-', 'room' => 'Kantin / Area Sekolah', 'is_break' => true],
                ['time' => '10:15 - 12:15', 'subject' => 'Basis Data & SQL Optimization', 'teacher' => 'Ibu Sita Nurhaliza, M.T', 'room' => 'Lab RPL 2', 'is_break' => false],
                ['time' => '12:15 - 13:00', 'subject' => 'ISHOMA', 'teacher' => '-', 'room' => 'Masjid Sekolah', 'is_break' => true],
                ['time' => '13:00 - 15:30', 'subject' => 'Bahasa Inggris Industri', 'teacher' => 'Ibu Maria Ulfah, M.Pd', 'room' => 'Ruang 12 RPL', 'is_break' => false],
            ],
            'Rabu' => [
                ['time' => '07:15 - 09:30', 'subject' => 'Matematika Terapan & Statistika', 'teacher' => 'Bpk. Hadi Purnomo, M.Pd', 'room' => 'Ruang 12 RPL', 'is_break' => false],
                ['time' => '09:45 - 12:15', 'subject' => 'Cloud Computing & DevOps Basics', 'teacher' => 'Bpk. Ahmad Fauzi, S.Kom', 'room' => 'Lab Software 1', 'is_break' => false],
                ['time' => '13:00 - 15:15', 'subject' => 'Pendidikan Pancasila & Kewarganegaraan', 'teacher' => 'Ibu Sri Rahayu, S.Pd', 'room' => 'Ruang 12 RPL', 'is_break' => false],
            ],
            'Kamis' => [
                ['time' => '07:15 - 09:30', 'subject' => 'Pendidikan Agama & Budi Pekerti', 'teacher' => 'Ustadz H. Lukman Hakim, M.Ag', 'room' => 'Masjid / Ruang 12 RPL', 'is_break' => false],
                ['time' => '09:45 - 12:15', 'subject' => 'Proyek Tugas Akhir / Side Project', 'teacher' => 'Tim Pembimbing Skripsi/TA', 'room' => 'Lab RPL 1', 'is_break' => false],
                ['time' => '13:00 - 15:15', 'subject' => 'Bahasa Indonesia & Penulisan Ilmiah', 'teacher' => 'Ibu Dewi Lestari, M.Pd', 'room' => 'Ruang 12 RPL', 'is_break' => false],
            ],
            'Jumat' => [
                ['time' => '07:00 - 08:00', 'subject' => 'Jumat Bersih & Olahraga Bersama', 'teacher' => 'Guru PJOK', 'room' => 'Lapangan Olahraga', 'is_break' => false],
                ['time' => '08:00 - 11:30', 'subject' => 'Pendidikan Jasmani, Olahraga, & Kesehatan', 'teacher' => 'Bpk. Bambang Irawan, S.Pd', 'room' => 'Lapangan / GOR', 'is_break' => false],
            ],
        ];

        return view('jadwal', compact('days', 'currentDay', 'schedule'));
    }
}
