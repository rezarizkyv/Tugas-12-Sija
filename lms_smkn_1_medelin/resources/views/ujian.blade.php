@extends('layouts.app')

@section('title', 'Ujian Online Aman (CBT) - SMKN 1 Medelin')

@section('content')
<div class="space-y-8" x-data="{ examActive: false, currentQ: 1, selectedAnswers: { 1: 'A', 3: 'A' }, doubtful: { 2: true }, submitModal: false, timer: 2840 }">

    <!-- Normal List View (When exam not active) -->
    <div x-show="!examActive" class="space-y-6">
        
        <!-- CBT Header Banner -->
        <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
            <div>
                <span class="px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 text-xs font-bold border border-rose-400/30">
                    <i class="fa-solid fa-lock mr-1"></i> Lockdown Browser Mode Enabled
                </span>
                <h2 class="text-3xl font-extrabold mt-2 tracking-tight">Sistem Ujian Online Aman (CBT)</h2>
                <p class="text-xs text-slate-300 mt-1 max-w-xl">
                    Sistem Penilaian Komputerisasi Terpadu SMKN 1 Medelin dilengkapi pencatat log anti-kecurangan (tab switch detector & window blur logger).
                </p>
            </div>

            <div>
                <button @click="examActive = true" class="px-6 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-500 text-white font-extrabold text-sm shadow-lg shadow-rose-600/30 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-play"></i> Simulasi Masuk Ujian CBT
                </button>
            </div>
        </div>

        <!-- Available Exams Grid -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Daftar Ujian & Evaluasi Pembelajaran</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($exams as $exam)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-700 text-[10px] font-extrabold uppercase">
                                {{ $exam['code'] }}
                            </span>
                            @if($exam['status'] === 'active')
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                    <i class="fa-solid fa-circle-play mr-1"></i> Ujian Aktif
                                </span>
                            @elseif($exam['status'] === 'upcoming')
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                    <i class="fa-solid fa-clock mr-1"></i> Terjadwal
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                                    <i class="fa-solid fa-circle-check mr-1"></i> Selesai (Nilai: {{ $exam['score'] ?? '-' }})
                                </span>
                            @endif
                        </div>

                        <h4 class="text-lg font-bold text-slate-800 mt-3 leading-snug">{{ $exam['title'] }}</h4>
                        <p class="text-xs text-slate-500 mt-1 font-medium"><i class="fa-solid fa-book mr-1"></i> {{ $exam['subject'] }}</p>

                        <div class="grid grid-cols-3 gap-2 mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-center text-xs">
                            <div>
                                <span class="text-slate-400 text-[10px] block">Durasi</span>
                                <span class="font-bold text-slate-800">{{ $exam['duration'] }} Menit</span>
                            </div>
                            <div class="border-l border-slate-200">
                                <span class="text-slate-400 text-[10px] block">Jumlah Soal</span>
                                <span class="font-bold text-slate-800">{{ $exam['questions_count'] }} Soal</span>
                            </div>
                            <div class="border-l border-slate-200">
                                <span class="text-slate-400 text-[10px] block">Keamanan</span>
                                <span class="font-bold text-rose-600">Lockdown</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        @if($exam['status'] === 'active')
                            <button @click="examActive = true" class="w-full py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-md transition-all">
                                Mulai Kerjakan Ujian Sekarang
                            </button>
                        @elseif($exam['status'] === 'upcoming')
                            <button disabled class="w-full py-3 rounded-2xl bg-slate-100 text-slate-400 font-bold text-xs cursor-not-allowed">
                                Belum Waktunya Dimulai ({{ $exam['start_time'] }})
                            </button>
                        @else
                            <button class="w-full py-3 rounded-2xl bg-slate-100 text-slate-700 font-bold text-xs border border-slate-200 hover:bg-slate-200 transition-all">
                                Lihat Pembahasan & Skor
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- CBT SECURE EXAM ROOM SIMULATOR (FULLSCREEN IMMERSIVE MODE) -->
    <div x-show="examActive" class="space-y-6" x-cloak>
        
        <!-- CBT Top Anti-Cheat Control Bar -->
        <div class="bg-slate-900 text-white p-4 rounded-3xl shadow-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-rose-500/30">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center text-lg font-bold animate-pulse">
                    <i class="fa-solid fa-shield-cat"></i>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-white">CBT Lockdown Active Mode</h3>
                    <p class="text-[10px] text-rose-300">Peringatan Kemaanan: Dilarang berpindah aplikasi atau tab browser!</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Countdown Timer -->
                <div class="px-4 py-2 rounded-2xl bg-slate-800 border border-slate-700 flex items-center gap-2 text-xs">
                    <i class="fa-regular fa-clock text-amber-400 text-base"></i>
                    <div>
                        <span class="text-[10px] text-slate-400 block font-semibold">Sisa Waktu:</span>
                        <span class="font-extrabold text-amber-400 text-sm">47:20 Menit</span>
                    </div>
                </div>

                <button @click="submitModal = true" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition-all">
                    <i class="fa-solid fa-paper-plane mr-1"></i> Selesaikan Ujian
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Question Content Panel (Left 3 Cols) -->
            <div class="lg:col-span-3 bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm flex flex-col justify-between min-h-[480px]">
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-6">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold">
                            Soal Nomor <span x-text="currentQ"></span> dari 20
                        </span>
                        <div class="flex items-center gap-2">
                            <button @click="doubtful[currentQ] = !doubtful[currentQ]" :class="doubtful[currentQ] ? 'bg-amber-500 text-white' : 'bg-slate-100 text-slate-600'" class="px-3 py-1 rounded-xl text-xs font-bold border transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-bookmark"></i> Ragul
                            </button>
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div class="text-sm sm:text-base font-semibold text-slate-800 leading-relaxed mb-6">
                        <template x-if="currentQ === 1">
                            <span>1. Di bawah ini yang merupakan keuntungan utama dari penggunaan arsitektur MVC (Model-View-Controller) dalam pengembangan aplikasi web modern dengan Laravel adalah...</span>
                        </template>
                        <template x-if="currentQ === 2">
                            <span>2. Perintah Artisan yang digunakan untuk menjalankan migrasi database serta mengisikan data dummy awal (seeding) secara bersamaan di Laravel adalah...</span>
                        </template>
                        <template x-if="currentQ === 3">
                            <span>3. Fungsi utama dari penggunaan token CSRF (@csrf) pada form HTML di Laravel adalah untuk...</span>
                        </template>
                    </div>

                    <!-- Multiple Choice Options -->
                    <div class="space-y-3">
                        <template x-if="currentQ === 1">
                            <div class="space-y-3">
                                <button @click="selectedAnswers[1] = 'A'" :class="selectedAnswers[1] === 'A' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="w-full text-left p-4 rounded-2xl border transition-all text-xs sm:text-sm flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs font-bold shrink-0">A</span>
                                    <span>Memisahkan logika bisnis, tampilan visual, dan penanganan request sehingga kode lebih terstruktur dan mudah di-maintain.</span>
                                </button>
                                <button @click="selectedAnswers[1] = 'B'" :class="selectedAnswers[1] === 'B' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="w-full text-left p-4 rounded-2xl border transition-all text-xs sm:text-sm flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0">B</span>
                                    <span>Mempercepat kecepatan koneksi internet pengguna secara otomatis saat mengakses server.</span>
                                </button>
                                <button @click="selectedAnswers[1] = 'C'" :class="selectedAnswers[1] === 'C' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="w-full text-left p-4 rounded-2xl border transition-all text-xs sm:text-sm flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0">C</span>
                                    <span>Menghilangkan kebutuhan akan basis data relasional MySQL.</span>
                                </button>
                            </div>
                        </template>

                        <template x-if="currentQ === 2">
                            <div class="space-y-3">
                                <button @click="selectedAnswers[2] = 'A'" :class="selectedAnswers[2] === 'A' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="w-full text-left p-4 rounded-2xl border transition-all text-xs sm:text-sm flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0">A</span>
                                    <code class="text-blue-700 font-bold">php artisan migrate:fresh --seed</code>
                                </button>
                                <button @click="selectedAnswers[2] = 'B'" :class="selectedAnswers[2] === 'B' ? 'border-blue-600 bg-blue-50 text-blue-900 font-bold' : 'border-slate-200 bg-white text-slate-700 hover:bg-slate-50'" class="w-full text-left p-4 rounded-2xl border transition-all text-xs sm:text-sm flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center text-xs font-bold shrink-0">B</span>
                                    <code class="text-slate-700 font-bold">php artisan make:migration --all</code>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Navigation Controls -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-100 mt-6">
                    <button @click="if(currentQ > 1) currentQ--" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all flex items-center gap-2">
                        <i class="fa-solid fa-chevron-left"></i> Soal Sebelumnya
                    </button>

                    <button @click="if(currentQ < 3) currentQ++" class="px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow transition-all flex items-center gap-2">
                        Soal Selanjutnya <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Question Number Map (Right Col) -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm h-fit">
                <h4 class="font-bold text-slate-800 text-sm mb-4 pb-3 border-b border-slate-100">Navigasi Peta Soal</h4>
                
                <div class="grid grid-cols-5 gap-2.5">
                    @for($i = 1; $i <= 20; $i++)
                    <button 
                        @click="currentQ = {{ $i }}"
                        :class="currentQ === {{ $i }} ? 'ring-2 ring-blue-600 font-extrabold' : ''"
                        class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs flex items-center justify-center transition-all relative">
                        {{ $i }}
                        <span x-show="selectedAnswers[{{ $i }}]" class="absolute -top-1 -right-1 w-3 h-3 bg-blue-600 rounded-full border-2 border-white" x-cloak></span>
                    </button>
                    @endfor
                </div>

                <div class="mt-6 space-y-2 text-[11px] text-slate-500">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-600"></span> <span>Sudah Dijawab</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span> <span>Ragu-ragu</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-slate-200"></span> <span>Belum Dijawab</span>
                    </div>
                </div>

                <button @click="examActive = false" class="mt-6 w-full py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs transition-all">
                    Keluar Simulasi CBT
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
