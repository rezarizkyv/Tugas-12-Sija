@extends('layouts.app')

@section('title', 'Jadwal Pelajaran Mingguan - SMKN 1 Medelin')

@section('content')
<div class="space-y-6" x-data="{ activeDay: 'Selasa' }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Jadwal Pelajaran Kelas XII RPL</h2>
            <p class="text-xs text-slate-500 mt-1">Tahun Ajaran 2025/2026 • Semester Genap</p>
        </div>
        
        <div class="px-4 py-2 rounded-2xl bg-blue-50 border border-blue-200 text-blue-700 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-clock"></i> Hari Aktif: <span class="text-blue-900 font-extrabold">Selasa</span>
        </div>
    </div>

    <!-- Day Navigation Buttons -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 custom-scrollbar">
        @foreach($days as $day)
        <button 
            @click="activeDay = '{{ $day }}'"
            :class="activeDay === '{{ $day }}' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'"
            class="px-6 py-3 rounded-2xl font-bold text-xs transition-all flex items-center gap-2">
            <i class="fa-solid fa-calendar-day"></i> {{ $day }}
        </button>
        @endforeach
    </div>

    <!-- Timetable List for Active Day -->
    @foreach($schedule as $dayName => $items)
    <div x-show="activeDay === '{{ $dayName }}'" class="space-y-4" x-cloak>
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 pb-3 border-b border-slate-100 flex items-center justify-between">
                <span>Jadwal Pelajaran {{ $dayName }}</span>
                <span class="text-xs font-semibold text-slate-400">{{ count($items) }} Sesi Pelajaran</span>
            </h3>

            <div class="space-y-3">
                @foreach($items as $item)
                <div class="p-4 rounded-2xl transition-all border {{ isset($item['is_active']) && $item['is_active'] ? 'bg-gradient-to-r from-blue-600 to-indigo-700 text-white shadow-lg shadow-blue-600/20 border-blue-500' : ($item['is_break'] ? 'bg-slate-50/80 border-slate-200 text-slate-500' : 'bg-white border-slate-200 text-slate-800 hover:border-blue-300') }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-4">
                            <div class="px-3 py-2 rounded-xl text-xs font-extrabold {{ isset($item['is_active']) && $item['is_active'] ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">
                                {{ $item['time'] }}
                            </div>
                            <div>
                                <h4 class="font-bold text-base {{ isset($item['is_active']) && $item['is_active'] ? 'text-white' : ($item['is_break'] ? 'text-slate-500 italic' : 'text-slate-800') }}">
                                    {{ $item['subject'] }}
                                </h4>
                                @if(!$item['is_break'])
                                <p class="text-xs mt-0.5 {{ isset($item['is_active']) && $item['is_active'] ? 'text-blue-100' : 'text-slate-500' }}">
                                    <i class="fa-solid fa-chalkboard-user mr-1"></i> {{ $item['teacher'] }}
                                </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-xl text-xs font-bold {{ isset($item['is_active']) && $item['is_active'] ? 'bg-white text-blue-900 shadow' : 'bg-slate-100 text-slate-600' }}">
                                <i class="fa-solid fa-door-open mr-1"></i> {{ $item['room'] }}
                            </span>
                            @if(isset($item['is_active']) && $item['is_active'])
                            <span class="px-3 py-1 rounded-xl bg-emerald-400 text-slate-900 font-extrabold text-[10px] uppercase tracking-wider animate-pulse">
                                Sedang Berlangsung
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection
