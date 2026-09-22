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

        $query = \App\Models\Course::query();
        
        if ($selectedMajor !== 'all') {
            $query->where('major', $selectedMajor);
        }
        
        $courses = $query->get();

        return view('elearning', compact('majors', 'courses', 'selectedMajor'));
    }

    public function show(\App\Models\Course $course)
    {
        // Load course with its modules, ordered by order_index
        $course->load(['modules' => function ($query) {
            $query->orderBy('order_index');
        }]);

        return view('elearning.show', compact('course'));
    }
}
