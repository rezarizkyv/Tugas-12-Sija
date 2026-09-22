@extends('layouts.app')

@section('title', 'Monitoring Kelas & E-Voting OSIS - SMKN 1 Medelin')

@section('content')
<div class="space-y-8" x-data="{ votedCandidate: null, showModal: false, selectedCandidate: null }">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-800 via-orange-800 to-red-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div>
            <span class="px-3 py-1 rounded-full bg-amber-500/30 text-amber-200 text-xs font-bold border border-amber-400/30">
                <i class="fa-solid fa-check-to-slot mr-1"></i> E-Voting Portal OSIS 2026
            </span>
            <h2 class="text-3xl font-extrabold mt-2 tracking-tight">Monitoring Kelas & Pemilihan OSIS</h2>
            <p class="text-xs text-amber-100 mt-1 max-w-xl">
                Sistem e-voting terintegrasi satu siswa satu suara (One-Student One-Vote) dengan token unik dan rekap suara realtime.
            </p>
        </div>

        <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 text-center min-w-[180px]">
            <span class="text-xs text-amber-200 font-semibold block">Total Suara Masuk</span>
            <span class="text-3xl font-extrabold text-white mt-0.5">1,066 Suara</span>
            <span class="text-[10px] text-emerald-300 block mt-1"><i class="fa-solid fa-signal animate-pulse"></i> Live Count Active</span>
        </div>
    </div>

    <!-- Class Monitoring Overview Matrix -->
    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-4 border-b border-slate-100 mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800">Monitoring Kehadiran Kelas {{ $classMonitoring['class_name'] }}</h3>
                <p class="text-xs text-slate-500">Wali Kelas: {{ $classMonitoring['homeroom_teacher'] }}</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                Kondisi Kelas: {{ $classMonitoring['status'] }}
            </span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 text-center">
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                <span class="text-xs text-slate-400 font-semibold block">Total Siswa</span>
                <span class="text-2xl font-extrabold text-slate-800 mt-1">{{ $classMonitoring['total_students'] }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200">
                <span class="text-xs text-emerald-600 font-semibold block">Hadir</span>
                <span class="text-2xl font-extrabold text-emerald-700 mt-1">{{ $classMonitoring['present'] }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200">
                <span class="text-xs text-amber-600 font-semibold block">Izin</span>
                <span class="text-2xl font-extrabold text-amber-700 mt-1">{{ $classMonitoring['permitted'] }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200">
                <span class="text-xs text-blue-600 font-semibold block">Sakit</span>
                <span class="text-2xl font-extrabold text-blue-700 mt-1">{{ $classMonitoring['sick'] }}</span>
            </div>
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200">
                <span class="text-xs text-rose-600 font-semibold block">Alpa</span>
                <span class="text-2xl font-extrabold text-rose-700 mt-1">{{ $classMonitoring['absent'] }}</span>
            </div>
        </div>
    </div>

    <!-- E-VOTING OSIS SECTION -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-extrabold text-slate-800">Kandidat Pasangan Calon Ketua & Wakil OSIS 2026</h3>
                <p class="text-xs text-slate-500">Pilih pasangan calon sesuai dengan visi dan misi terbaik menurut Anda</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($candidates as $c)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Header Number Badge -->
                    <div class="h-24 bg-gradient-to-r {{ $c['color'] }} p-6 text-white flex items-center justify-between relative">
                        <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl font-black">
                            0{{ $c['number'] }}
                        </div>
                        <span class="px-3 py-1 rounded-full bg-black/20 text-xs font-bold backdrop-blur-md">
                            {{ $c['votes'] }} Suara ({{ $c['percentage'] }}%)
                        </span>
                    </div>

                    <div class="p-6">
                        <h4 class="text-base font-extrabold text-slate-800">{{ $c['leader'] }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Wakil: <span class="font-bold text-slate-700">{{ $c['vice'] }}</span></p>

                        <div class="mt-4 p-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs italic text-slate-600">
                            "{{ $c['tagline'] }}"
                        </div>

                        <!-- Vision Preview -->
                        <div class="mt-4 text-xs">
                            <span class="font-bold text-slate-700 block">Visi Utama:</span>
                            <p class="text-slate-500 mt-1 leading-relaxed line-clamp-2">{{ $c['vision'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-0 space-y-2">
                    <button @click="selectedCandidate = {{ json_encode($c) }}; showModal = true" class="w-full py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all">
                        Lihat Visi & Misi Lengkap
                    </button>
                    
                    <button 
                        @click="votedCandidate = {{ $c['number'] }}" 
                        :disabled="votedCandidate !== null"
                        :class="votedCandidate === {{ $c['number'] }} ? 'bg-emerald-600 text-white' : 'bg-orange-600 hover:bg-orange-500 text-white'"
                        class="w-full py-3 rounded-2xl font-extrabold text-xs shadow-md transition-all flex items-center justify-center gap-2">
                        <template x-if="votedCandidate === {{ $c['number'] }}">
                            <span><i class="fa-solid fa-check-double mr-1"></i> Pilihan Anda (Tersimpan)</span>
                        </template>
                        <template x-if="votedCandidate !== {{ $c['number'] }}">
                            <span><i class="fa-solid fa-vote-yea mr-1"></i> Coblos Paslon 0{{ $c['number'] }}</span>
                        </template>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Candidate Detail Modal -->
    <div x-show="showModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-cloak>
        <div @click.outside="showModal = false" class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-100 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800" x-text="'Detail Visi & Misi Paslon 0' + (selectedCandidate ? selectedCandidate.number : '')"></h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="space-y-4 text-xs sm:text-sm">
                <div>
                    <span class="font-bold text-slate-800 block text-xs uppercase tracking-wide text-orange-600">Ketua & Wakil</span>
                    <p class="font-bold text-slate-800 text-base mt-0.5" x-text="selectedCandidate ? selectedCandidate.leader : ''"></p>
                    <p class="text-slate-500 text-xs" x-text="selectedCandidate ? 'Wakil: ' + selectedCandidate.vice : ''"></p>
                </div>

                <div>
                    <span class="font-bold text-slate-800 block text-xs uppercase tracking-wide text-orange-600">Visi</span>
                    <p class="text-slate-600 leading-relaxed mt-1" x-text="selectedCandidate ? selectedCandidate.vision : ''"></p>
                </div>

                <div>
                    <span class="font-bold text-slate-800 block text-xs uppercase tracking-wide text-orange-600">Misi Utama</span>
                    <ul class="list-disc pl-5 text-slate-600 space-y-1 mt-1">
                        <template x-for="m in (selectedCandidate ? selectedCandidate.mission : [])">
                            <li x-text="m"></li>
                        </template>
                    </ul>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button @click="showModal = false" class="px-5 py-2.5 rounded-2xl bg-slate-100 font-bold text-xs text-slate-700">Tutup Modal</button>
            </div>
        </div>
    </div>

</div>
@endsection
