@extends('layouts.app')

@section('title', 'Gradebook & Raport Digital - SMKN 1 Medelin')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-900 via-indigo-900 to-blue-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div>
            <span class="px-3 py-1 rounded-full bg-purple-500/30 text-purple-200 text-xs font-bold border border-purple-400/30">
                <i class="fa-solid fa-award mr-1"></i> Transkrip Akademik Digital
            </span>
            <h2 class="text-3xl font-extrabold mt-2 tracking-tight">Raport Digital & Rekapitulasi Nilai</h2>
            <p class="text-xs text-purple-200 mt-1 max-w-xl">
                Rekap nilai transparan per mata pelajaran, nilai tugas, kuis, UTS, dan UAS semester berjalan.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-5 py-3 rounded-2xl bg-white text-purple-900 font-extrabold text-xs shadow hover:bg-purple-50 transition-all flex items-center gap-2">
                <i class="fa-solid fa-print"></i> Cetak / Ekspor PDF
            </button>
        </div>
    </div>

    <!-- Summary Academic Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="glass-card rounded-2xl p-6 border border-slate-200/80">
            <span class="text-xs text-slate-500 font-bold uppercase">Indeks Prestasi (IPK)</span>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['gpa'] }} <span class="text-xs text-slate-400 font-medium">/ 4.00</span></h3>
            <span class="text-xs text-emerald-600 font-bold mt-1 block">{{ $summary['predikat'] }}</span>
        </div>

        <div class="glass-card rounded-2xl p-6 border border-slate-200/80">
            <span class="text-xs text-slate-500 font-bold uppercase">Rata-Rata Nilai</span>
            <h3 class="text-3xl font-extrabold text-slate-800 mt-1">{{ $summary['score_avg'] }}</h3>
            <span class="text-xs text-blue-600 font-bold mt-1 block">Skala 100</span>
        </div>

        <div class="glass-card rounded-2xl p-6 border border-slate-200/80">
            <span class="text-xs text-slate-500 font-bold uppercase">Peringkat Kelas</span>
            <h3 class="text-2xl font-extrabold text-slate-800 mt-1">Peringkat 2</h3>
            <span class="text-xs text-purple-600 font-bold mt-1 block">Dari 36 Siswa (XII RPL 1)</span>
        </div>

        <div class="glass-card rounded-2xl p-6 border border-slate-200/80">
            <span class="text-xs text-slate-500 font-bold uppercase">Status Kelulusan Mapel</span>
            <h3 class="text-3xl font-extrabold text-emerald-600 mt-1">100%</h3>
            <span class="text-xs text-emerald-600 font-bold mt-1 block">Seluruh Mapel Tuntas KKM</span>
        </div>
    </div>

    <!-- Detailed Subject Grades Table -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Rincian Nilai Mata Pelajaran</h3>
                <p class="text-xs text-slate-500">Breakdown bobot Tugas (20%), Kuis (20%), UTS (30%), & UAS (30%)</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Status: Terverifikasi Wali Kelas</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead>
                    <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase">
                        <th class="pb-3">Kode & Mapel</th>
                        <th class="pb-3">Guru Pengajar</th>
                        <th class="pb-3 text-center">Tugas</th>
                        <th class="pb-3 text-center">Kuis</th>
                        <th class="pb-3 text-center">UTS</th>
                        <th class="pb-3 text-center">UAS</th>
                        <th class="pb-3 text-center">Nilai Akhir</th>
                        <th class="pb-3 text-right">Predikat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($grades as $g)
                    <tr>
                        <td class="py-4 font-bold text-slate-800">
                            <div>{{ $g['subject_name'] }}</div>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $g['subject_code'] }}</span>
                        </td>
                        <td class="py-4 text-slate-600 text-xs">{{ $g['teacher'] }}</td>
                        <td class="py-4 text-center font-semibold text-slate-700">{{ $g['assignment_score'] }}</td>
                        <td class="py-4 text-center font-semibold text-slate-700">{{ $g['quiz_score'] }}</td>
                        <td class="py-4 text-center font-semibold text-slate-700">{{ $g['uts_score'] }}</td>
                        <td class="py-4 text-center font-semibold text-slate-700">{{ $g['uas_score'] }}</td>
                        <td class="py-4 text-center font-extrabold text-blue-600 text-base">{{ $g['final_score'] }}</td>
                        <td class="py-4 text-right">
                            <span class="px-3 py-1 rounded-xl bg-purple-100 text-purple-700 font-extrabold text-xs">
                                {{ $g['letter_grade'] }} ({{ $g['status'] }})
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
