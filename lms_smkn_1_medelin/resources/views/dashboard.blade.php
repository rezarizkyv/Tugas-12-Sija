@extends('layouts.app')

@section('title', 'Dashboard Utama - SMKN 1 Medelin')

@section('content')
<div class="space-y-8">

    <!-- HERO WELCOME BANNER -->
    <div class="relative overflow-hidden rounded-3xl gradient-hero text-white p-8 sm:p-10 shadow-xl shadow-blue-900/20 border border-blue-500/20">
        <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-cyan-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute right-40 top-0 w-60 h-60 bg-blue-400/20 rounded-full blur-2xl pointer-events-none"></div>
        
        <div class="relative z-10 max-w-3xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-cyan-300 text-xs font-semibold mb-4 backdrop-blur-md">
                <i class="fa-solid fa-sparkles"></i> Portal Sekolah Terpadu 2026
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                Selamat Datang di Portal Digital SMKN 1 Medelin!
            </h2>
            <p class="mt-3 text-slate-200 text-sm sm:text-base leading-relaxed font-light">
                Satu portal terintegrasi untuk e-learning, kehadiran berbasis lokasi (geolocation), dan ujian online aman (CBT).
            </p>
            
            <div class="mt-6 flex flex-wrap items-center gap-4">
                <a href="{{ route('elearning') }}" class="px-5 py-2.5 rounded-xl bg-white text-blue-900 font-bold text-sm shadow-md hover:bg-cyan-50 hover:shadow-cyan-500/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-book-open"></i> Buka E-Learning
                </a>
                <a href="{{ route('presensi') }}" class="px-5 py-2.5 rounded-xl bg-blue-700/60 hover:bg-blue-700 text-white font-semibold text-sm border border-blue-400/30 backdrop-blur-md transition-all flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left"></i> Presensi Hari Ini
                </a>
            </div>
        </div>
    </div>

    <!-- QUICK STATS SECTION (4 KARTU STATISTIK) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat 1: Kehadiran -->
        <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition-all border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kehadiran Bulan Ini</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">98%</h3>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 mt-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Sangat Baik
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
        </div>

        <!-- Stat 2: Tugas Tertunda -->
        <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition-all border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tugas Tertunda</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">3 <span class="text-sm font-medium text-slate-500">Tugas</span></h3>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-600 mt-1">
                    <i class="fa-solid fa-clock"></i> Deadline Dekat
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-list-check"></i>
            </div>
        </div>

        <!-- Stat 3: Ujian Mendatang -->
        <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition-all border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ujian Mendatang</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">1 <span class="text-sm font-medium text-slate-500">Ujian</span></h3>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 mt-1">
                    <i class="fa-solid fa-shield"></i> CBT Mode Ready
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-laptop-code"></i>
            </div>
        </div>

        <!-- Stat 4: Rata-rata Nilai -->
        <div class="glass-card rounded-2xl p-6 shadow-sm hover:shadow-md transition-all border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Rata-rata Nilai</p>
                <h3 class="text-3xl font-extrabold text-slate-800 mt-1">88.5</h3>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-purple-600 mt-1">
                    <i class="fa-solid fa-trophy"></i> Rank 2 di Kelas
                </span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-award"></i>
            </div>
        </div>
    </div>

    <!-- GRID MENU UTAMA (MAIN FEATURES - CARD UI) -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Fitur Utama Portal</h3>
            <span class="text-xs text-slate-500 font-medium">Klik kartu untuk membuka modul</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1: E-Learning -->
            <a href="{{ route('elearning') }}" class="group relative bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center text-xl shadow-lg shadow-blue-500/30 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">E-Learning Hub</h4>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Akses course per jurusan, modul PDF/Video, tugas harian, dan quiz interaktif.</p>
                <div class="mt-4 flex items-center text-xs font-bold text-blue-600 group-hover:translate-x-1 transition-transform">
                    <span>Masuk Pembelajaran</span> <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </div>
            </a>

            <!-- Card 2: Presensi Realtime -->
            <a href="{{ route('presensi') }}" class="group relative bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-emerald-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-600 text-white flex items-center justify-center text-xl shadow-lg shadow-emerald-500/30 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">Presensi Geofence</h4>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Rekap absensi mata pelajaran dan presensi harian berbasis GPS radius sekolah.</p>
                <div class="mt-4 flex items-center text-xs font-bold text-emerald-600 group-hover:translate-x-1 transition-transform">
                    <span>Lihat Absensi</span> <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </div>
            </a>

            <!-- Card 3: Ujian Online CBT -->
            <a href="{{ route('ujian') }}" class="group relative bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-rose-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-rose-600 to-pink-600 text-white flex items-center justify-center text-xl shadow-lg shadow-rose-500/30 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-800 group-hover:text-rose-600 transition-colors">Ujian Online CBT</h4>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Sistem ujian aman dengan penguncian layar, timer akurat, dan anti-cheat log.</p>
                <div class="mt-4 flex items-center text-xs font-bold text-rose-600 group-hover:translate-x-1 transition-transform">
                    <span>Ruang Ujian CBT</span> <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </div>
            </a>

            <!-- Card 4: Gradebook (Nilai) -->
            <a href="{{ route('gradebook') }}" class="group relative bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-purple-500/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-700 text-white flex items-center justify-center text-xl shadow-lg shadow-purple-500/30 mb-4 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-award"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-800 group-hover:text-purple-600 transition-colors">Gradebook Digital</h4>
                <p class="text-xs text-slate-500 mt-1.5 leading-relaxed">Raport digital terpadu, rincian nilai UTS/UAS, tugas, serta grafik perkembangan IPK.</p>
                <div class="mt-4 flex items-center text-xs font-bold text-purple-600 group-hover:translate-x-1 transition-transform">
                    <span>Buka Raport</span> <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- RECENT ACTIVITY & ANNOUNCEMENTS SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Activity Timeline / List -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Aktivitas Akademik Terbaru</h3>
                    <p class="text-xs text-slate-500">Pembaruan real-time dari pengajar dan kurikulum sekolah</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">Realtime Stream</span>
            </div>

            <div class="space-y-4">
                @foreach($activities as $act)
                <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50/80 hover:bg-blue-50/40 border border-slate-100 transition-colors">
                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-blue-600 text-lg shadow-sm shrink-0 mt-0.5">
                        @if($act['type'] === 'assignment')
                            <i class="fa-solid fa-pen-ruler"></i>
                        @elseif($act['type'] === 'announcement')
                            <i class="fa-solid fa-bullhorn text-amber-500"></i>
                        @elseif($act['type'] === 'attendance')
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        @else
                            <i class="fa-solid fa-book-open"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-extrabold uppercase tracking-wide">
                                {{ $act['badge'] }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">{{ $act['time'] }}</span>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800 mt-1.5">{{ $act['title'] }}</h4>
                        <p class="text-xs text-slate-500 mt-1">Oleh: {{ $act['teacher'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Col: Upcoming Schedule Widget & OSIS Quick Banner -->
        <div class="space-y-6">
            
            <!-- Quick Schedule -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="font-bold text-slate-800 text-sm">Jadwal Hari Ini (Selasa)</h4>
                    <a href="{{ route('jadwal') }}" class="text-xs text-blue-600 font-bold hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-3">
                    <div class="p-3.5 rounded-2xl bg-blue-600 text-white shadow-md shadow-blue-600/20">
                        <div class="flex items-center justify-between text-xs text-blue-100 font-medium">
                            <span>07:30 - 09:45 WIB</span>
                            <span class="px-2 py-0.5 rounded bg-blue-500 font-bold text-[10px]">Sedang Berlangsung</span>
                        </div>
                        <h5 class="text-sm font-bold mt-1">Pemrograman Web & Mobile</h5>
                        <p class="text-xs text-blue-200 mt-0.5"><i class="fa-solid fa-door-open mr-1"></i> Lab RPL 2 • Bpk. Ahmad Fauzi</p>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="flex items-center justify-between text-xs text-slate-400 font-medium">
                            <span>10:15 - 12:15 WIB</span>
                            <span>Mendatang</span>
                        </div>
                        <h5 class="text-sm font-bold text-slate-800 mt-1">Basis Data & SQL Optimization</h5>
                        <p class="text-xs text-slate-500 mt-0.5"><i class="fa-solid fa-door-open mr-1"></i> Lab RPL 2 • Ibu Sita Nurhaliza</p>
                    </div>
                </div>
            </div>

            <!-- E-Voting OSIS Banner Card -->
            <div class="rounded-3xl bg-gradient-to-br from-amber-500 to-orange-600 text-white p-6 shadow-lg shadow-orange-500/20 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                <span class="px-2.5 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-bold tracking-wider uppercase backdrop-blur-md">E-Voting Pemilu OSIS</span>
                <h4 class="text-lg font-extrabold mt-2 leading-tight">Pemilihan Ketua & Wakil OSIS 2026</h4>
                <p class="text-xs text-amber-100 mt-1 leading-relaxed">Gunakan hak suara Anda. Satu siswa, satu token rahasia.</p>
                <a href="{{ route('monitoring-osis') }}" class="mt-4 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-orange-600 font-bold text-xs shadow hover:bg-amber-50 transition-all">
                    <i class="fa-solid fa-check-to-slot"></i> Masuk Bilik Suara
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
