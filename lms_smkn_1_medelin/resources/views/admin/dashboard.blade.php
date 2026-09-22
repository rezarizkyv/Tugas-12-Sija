@extends('layouts.app')

@section('title', 'Dashboard Admin - SMKN 1 Medelin')

@section('content')
<div class="space-y-8">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 text-white p-8 rounded-3xl shadow-xl relative overflow-hidden flex justify-between items-center">
        <div class="relative z-10">
            <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold border border-blue-400/30 uppercase tracking-wider">
                <i class="fa-solid fa-shield-halved mr-1"></i> Admin Panel
            </span>
            <h2 class="text-3xl font-extrabold mt-3 tracking-tight">Manajemen Sistem & Pengguna</h2>
            <p class="text-sm text-slate-300 mt-1 max-w-xl">
                Pantau seluruh aktivitas siswa, kelola akun, dan cek ketuntasan tugas dengan mudah.
            </p>
        </div>
        <div class="hidden md:block opacity-20">
            <i class="fa-solid fa-users-gear text-9xl"></i>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Siswa</p>
                <h3 class="text-2xl font-black text-slate-800">{{ $stats['total_users'] }}</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mata Pelajaran</p>
                <h3 class="text-2xl font-black text-slate-800">5 Aktif</h3>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-2xl">
                <i class="fa-solid fa-file-circle-exclamation"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tugas Menunggak</p>
                <h3 class="text-2xl font-black text-slate-800">{{ count($missingTasks) }}</h3>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Tabel User Biasa -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Daftar Siswa (User Biasa)</h3>
                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold">{{ count($users) }} Terdaftar</span>
            </div>
            <div class="p-0 flex-1">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="p-4 font-bold">Nama / Username</th>
                                <th class="p-4 font-bold">Email</th>
                                <th class="p-4 font-bold">Kelas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $user)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-slate-800">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">@ {{ $user->username }}</div>
                                </td>
                                <td class="p-4 text-sm text-slate-600">{{ $user->email }}</td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                                        {{ $user->kelas ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-slate-500 text-sm">Belum ada user biasa.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tabel Tugas Belum Diunggah -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-rose-50/30">
                <h3 class="text-lg font-bold text-slate-800">Pemantauan Tugas Menunggak</h3>
                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Perhatian</span>
            </div>
            <div class="p-0 flex-1">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                                <th class="p-4 font-bold">Nama Siswa</th>
                                <th class="p-4 font-bold">Mata Pelajaran</th>
                                <th class="p-4 font-bold">Tugas Terlewat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($missingTasks as $missing)
                            <tr class="hover:bg-rose-50/30 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-slate-800 flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500 text-xs font-bold">
                                            {{ substr($missing->student, 0, 1) }}
                                        </div>
                                        {{ $missing->student }}
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-slate-600 font-medium">{{ $missing->course }}</td>
                                <td class="p-4">
                                    <span class="text-rose-600 text-sm font-bold flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-xmark"></i> {{ $missing->task }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-emerald-500 text-sm font-bold">
                                    <i class="fa-solid fa-check-circle text-2xl block mb-2"></i>
                                    Luar biasa! Semua siswa telah mengumpulkan tugas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
