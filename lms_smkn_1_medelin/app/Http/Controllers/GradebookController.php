<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GradebookController extends Controller
{
    public function index()
    {
        $summary = [
            'gpa' => 3.82, // Out of 4.00
            'score_avg' => 88.5,
            'completed_courses' => 8,
            'rank' => '2 dari 36 Siswa (XII RPL 1)',
            'predikat' => 'Sangat Memuaskan (A)',
        ];

        $grades = [
            [
                'subject_code' => 'RPL-XII-WEB',
                'subject_name' => 'Pemrograman Web & Perangkat Bergerak',
                'teacher' => 'Bpk. Ahmad Fauzi, S.Kom',
                'assignment_score' => 92,
                'quiz_score' => 88,
                'uts_score' => 90,
                'uas_score' => 94,
                'final_score' => 91.5,
                'letter_grade' => 'A',
                'status' => 'Tuntas',
            ],
            [
                'subject_code' => 'RPL-XII-BD',
                'subject_name' => 'Basis Data & SQL Optimization',
                'teacher' => 'Ibu Sita Nurhaliza, M.T',
                'assignment_score' => 95,
                'quiz_score' => 90,
                'uts_score' => 88,
                'uas_score' => 92,
                'final_score' => 91.2,
                'letter_grade' => 'A',
                'status' => 'Tuntas',
            ],
            [
                'subject_code' => 'RPL-XII-PBO',
                'subject_name' => 'Pemrograman Berorientasi Objek',
                'teacher' => 'Bpk. Rizky Ramadhan, S.Kom',
                'assignment_score' => 85,
                'quiz_score' => 82,
                'uts_score' => 86,
                'uas_score' => 88,
                'final_score' => 85.5,
                'letter_grade' => 'A-',
                'status' => 'Tuntas',
            ],
            [
                'subject_code' => 'MAT-XII',
                'subject_name' => 'Matematika Terapan & Statistika',
                'teacher' => 'Bpk. Hadi Purnomo, M.Pd',
                'assignment_score' => 84,
                'quiz_score' => 80,
                'uts_score' => 85,
                'uas_score' => 86,
                'final_score' => 83.8,
                'letter_grade' => 'B+',
                'status' => 'Tuntas',
            ],
            [
                'subject_code' => 'BIG-XII',
                'subject_name' => 'Bahasa Inggris Industri',
                'teacher' => 'Ibu Maria Ulfah, M.Pd',
                'assignment_score' => 90,
                'quiz_score' => 88,
                'uts_score' => 89,
                'uas_score' => 91,
                'final_score' => 89.8,
                'letter_grade' => 'A',
                'status' => 'Tuntas',
            ],
        ];

        return view('gradebook', compact('summary', 'grades'));
    }
}
