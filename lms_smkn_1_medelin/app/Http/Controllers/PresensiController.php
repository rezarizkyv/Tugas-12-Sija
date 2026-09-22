<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $schoolGeofence = [
            'name' => 'Kampus SMKN 1 Medelin Utama',
            'latitude' => -6.402484,
            'longitude' => 106.836100,
            'radius' => 150, // in meters
        ];

        $todayStatus = [
            'has_checked_in' => true,
            'check_in_time' => '07:12:45 WIB',
            'check_out_time' => null,
            'distance_meters' => 24.5,
            'status' => 'hadir',
            'is_valid_location' => true,
        ];

        $subjectAttendance = [
            [
                'subject' => 'Pemrograman Web & Perangkat Bergerak',
                'teacher' => 'Bpk. Ahmad Fauzi, S.Kom',
                'time' => '07:30 - 09:45 WIB',
                'status' => 'Hadir (GPS Verified)',
            ],
            [
                'subject' => 'Basis Data & SQL Optimization',
                'teacher' => 'Ibu Sita Nurhaliza, M.T',
                'time' => '10:00 - 12:15 WIB',
                'status' => 'Hadir (GPS Verified)',
            ],
            [
                'subject' => 'Bahasa Inggris Industri',
                'teacher' => 'Ibu Maria Ulfah, M.Pd',
                'time' => '13:00 - 15:15 WIB',
                'status' => 'Belum Dimulai',
            ],
        ];

        $history = [
            ['date' => '2026-09-15', 'day' => 'Selasa', 'in' => '07:12', 'out' => '15:30', 'status' => 'Hadir', 'loc' => '24m dari Sekolah'],
            ['date' => '2026-09-14', 'day' => 'Senin', 'in' => '07:05', 'out' => '15:35', 'status' => 'Hadir', 'loc' => '18m dari Sekolah'],
            ['date' => '2026-09-12', 'day' => 'Jumat', 'in' => '07:14', 'out' => '11:45', 'status' => 'Hadir', 'loc' => '31m dari Sekolah'],
            ['date' => '2026-09-11', 'day' => 'Kamis', 'in' => '07:10', 'out' => '15:30', 'status' => 'Hadir', 'loc' => '12m dari Sekolah'],
            ['date' => '2026-09-10', 'day' => 'Rabu', 'in' => '07:22', 'out' => '15:32', 'status' => 'Terlambat', 'loc' => '45m dari Sekolah'],
        ];

        return view('presensi', compact('schoolGeofence', 'todayStatus', 'subjectAttendance', 'history'));
    }
}
