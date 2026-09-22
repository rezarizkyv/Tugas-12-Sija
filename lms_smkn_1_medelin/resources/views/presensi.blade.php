@extends('layouts.app')

@section('title', 'Presensi Geofence Realtime - SMKN 1 Medelin')

@section('content')
<div class="space-y-8" x-data="{ clockInDone: true, isLocating: false, gpsValid: true, distance: 24.5 }">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-emerald-800 to-teal-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
        <div class="relative z-10">
            <span class="px-3 py-1 rounded-full bg-emerald-500/30 text-emerald-300 text-xs font-bold border border-emerald-400/30">
                <i class="fa-solid fa-satellite-dish animate-pulse mr-1"></i> Geofencing System Active
            </span>
            <h2 class="text-3xl font-extrabold mt-2 tracking-tight">Presensi Realtime Berbasis GPS</h2>
            <p class="text-xs text-emerald-100 mt-1 max-w-xl">
                Kehadiran divalidasi berdasarkan titik koordinat GPS (Latitude/Longitude) dan radius geofence kampus SMKN 1 Medelin.
            </p>
        </div>

        <div class="relative z-10 bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/20 text-center min-w-[200px]">
            <span class="text-xs text-emerald-200 font-semibold uppercase block">Radius Geofence</span>
            <span class="text-2xl font-extrabold text-white mt-0.5">150 Meter</span>
            <span class="text-[10px] text-emerald-300 block mt-1">Koordinat: -6.402484, 106.836100</span>
        </div>
    </div>

    <!-- Clock-in Widget & Subject Attendance -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Col: Live Clock In / Out Simulator -->
        <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm">Status Presensi Harian</h3>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Selasa, 15 Sep 2026</span>
                </div>

                <!-- Clock Display -->
                <div class="text-center py-6">
                    <div class="w-20 h-20 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-3 shadow-inner">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h4 class="text-4xl font-extrabold text-slate-800 tracking-tight" id="liveClock">07:12:45</h4>
                    <p class="text-xs text-slate-500 font-medium mt-1">Waktu Indonesia Barat (WIB)</p>
                </div>

                <!-- GPS Location Verification Card -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Titik Geofence:</span>
                        <span class="font-bold text-slate-800">{{ $schoolGeofence['name'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Jarak Terdeteksi:</span>
                        <span class="font-bold text-emerald-600">24.5 meter (Di Dalam Area)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 font-medium">Status Akurasi:</span>
                        <span class="font-bold text-blue-600"><i class="fa-solid fa-circle-check text-emerald-500"></i> High Precision GPS</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-6">
                <button class="w-full py-3.5 rounded-2xl bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 cursor-default">
                    <i class="fa-solid fa-circle-check"></i> Jam Datang Terkonfirmasi (07:12 WIB)
                </button>
            </div>
        </div>

        <!-- Right 2 Cols: Subject Attendance & History -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Subject Attendance Table -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
                <h3 class="font-bold text-slate-800 text-base mb-4">Presensi Per Mata Pelajaran (Hari Ini)</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase">
                                <th class="pb-3">Mata Pelajaran</th>
                                <th class="pb-3">Waktu Pelajaran</th>
                                <th class="pb-3">Pengajar</th>
                                <th class="pb-3 text-right">Status Absensi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($subjectAttendance as $sub)
                            <tr>
                                <td class="py-3.5 font-bold text-slate-800">{{ $sub['subject'] }}</td>
                                <td class="py-3.5 text-slate-500">{{ $sub['time'] }}</td>
                                <td class="py-3.5 text-slate-600 font-medium">{{ $sub['teacher'] }}</td>
                                <td class="py-3.5 text-right">
                                    @if(str_contains($sub['status'], 'Hadir'))
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 font-bold">
                                            <i class="fa-solid fa-check mr-1"></i> {{ $sub['status'] }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 font-medium">
                                            {{ $sub['status'] }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Attendance History -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm">
                <h3 class="font-bold text-slate-800 text-base mb-4">Riwayat Kehadiran 5 Hari Terakhir</h3>
                
                <div class="space-y-3">
                    @foreach($history as $h)
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 border border-slate-100 text-xs">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                                <i class="fa-solid fa-calendar-day"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $h['day'] }}, {{ $h['date'] }}</h4>
                                <span class="text-[10px] text-slate-400">Datang: {{ $h['in'] }} WIB • Pulang: {{ $h['out'] }} WIB</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $h['status'] === 'Hadir' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $h['status'] }}
                            </span>
                            <span class="block text-[10px] text-slate-400 mt-0.5">{{ $h['loc'] }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
