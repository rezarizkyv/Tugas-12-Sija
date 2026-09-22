<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElearningController extends Controller
{
    public function index(Request $request)
    {
        $selectedMajor = $request->query('major', 'all');

        $majors = [
            ['id' => 'all', 'name' => 'Semua Jurusan'],
            ['id' => 'rpl', 'name' => 'Rekayasa Perangkat Lunak (RPL)'],
            ['id' => 'tkj', 'name' => 'Teknik Komputer & Jaringan (TKJ)'],
            ['id' => 'dkv', 'name' => 'Desain Komunikasi Visual (DKV)'],
            ['id' => 'tkr', 'name' => 'Teknik Kendaraan Ringan (TKR)'],
        ];

        $courses = [
            [
                'id' => 1,
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
                'id' => 2,
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
                'id' => 3,
                'major' => 'tkj',
                'code' => 'TKJ-XII-NET',
                'title' => 'Administrasi Infrastruktur Jaringan (MikroTik/Cisco)',
                'teacher' => 'Bpk. Hendra Wijaya, S.T',
                'modules_count' => 10,
                'assignments_count' => 3,
                'progress' => 70,
                'icon' => 'network',
                'color' => 'from-purple-600 to-indigo-800',
            ],
            [
                'id' => 4,
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
                'id' => 5,
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

        if ($selectedMajor !== 'all') {
            $courses = array_filter($courses, fn($c) => $c['major'] === $selectedMajor);
        }

        return view('elearning', compact('majors', 'courses', 'selectedMajor'));
    }
}
