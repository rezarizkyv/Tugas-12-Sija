@extends('layouts.app')

@section('title', 'E-Learning & Katalog Pembelajaran - SMKN 1 Medelin')

@section('content')
<div class="space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Katalog E-Learning & Modul</h2>
            <p class="text-xs text-slate-500 mt-1">Akses materi pembelajaran terstruktur per program keahlian dan jurusan</p>
        </div>
        
        <!-- Search Filter -->
        <div class="w-full md:w-80 relative">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" placeholder="Cari mata pelajaran / modul..." class="w-full pl-11 pr-4 py-2.5 rounded-2xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
    </div>

    <!-- Major Category Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 custom-scrollbar">
        @foreach($majors as $m)
        <a href="{{ route('elearning', ['major' => $m['id']]) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all {{ $selectedMajor === $m['id'] ? 'bg-blue-600 text-white shadow-md shadow-blue-600/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
             {{ $m['name'] }}
        </a>
        @endforeach
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-24">
        @foreach($courses as $course)
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col justify-between">
            <div>
                <!-- Top Color Header -->
                <div class="h-28 bg-gradient-to-r {{ $course->color }} p-6 text-white relative flex justify-between items-start">
                    <span class="px-2.5 py-1 rounded-lg bg-white/20 backdrop-blur-md text-[10px] font-extrabold tracking-wider uppercase">
                        {{ strtoupper($course->major) }}
                    </span>
                    <span class="text-xs font-bold bg-black/20 px-2.5 py-1 rounded-lg backdrop-blur-md">
                        {{ $course->code }}
                    </span>
                </div>

                <div class="p-6">
                    <h3 class="text-lg font-bold text-slate-800 leading-snug hover:text-blue-600 transition-colors cursor-pointer">
                        {{ $course->title }}
                    </h3>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-user-tie text-blue-600"></i> {{ $course->teacher }}
                    </p>

                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 gap-3 mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="text-center">
                            <span class="text-slate-400 block text-[10px] font-semibold uppercase">Modul</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $course->modules_count }} File/Video</span>
                        </div>
                        <div class="text-center border-l border-slate-200">
                            <span class="text-slate-400 block text-[10px] font-semibold uppercase">Tugas</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $course->assignments_count }} Tugas</span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-1">
                            <span>Progres Kelengkapan</span>
                            <span class="text-blue-600">{{ $course->progress }}%</span>
                        </div>
                        <div class="w-full h-2 rounded-full bg-slate-100 overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $course->progress }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sticky Action Buttons -->
            <div class="sticky bottom-0 left-0 right-0 p-6 pt-4 bg-gradient-to-t from-white via-white to-transparent border-t border-slate-100 flex gap-2 z-10">
                <button class="flex-1 py-2.5 rounded-2xl bg-slate-900 hover:bg-blue-600 text-white font-bold text-xs shadow transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-folder-open"></i> Modul
                </button>
                <a href="{{ route('ujian', ['course' => $course->id]) }}" class="flex-1 py-2.5 rounded-2xl bg-white border-2 border-slate-900 hover:bg-slate-900 hover:text-white text-slate-900 font-bold text-xs shadow transition-all flex items-center justify-center gap-2 text-center">
                    <i class="fa-solid fa-file-pen"></i> Ujian
                </a>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
