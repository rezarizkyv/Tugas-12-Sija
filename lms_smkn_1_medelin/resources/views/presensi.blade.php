@extends('layouts.app')

@section('title', 'Presensi Geofence Realtime - SMKN 1 Medelin')

@section('content')
<div class="space-y-8" x-data="{ clockInDone: true, isLocating: false, gpsValid: true, distance: 24.5 }">

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-800 to-blue-900 text-white p-8 rounded-3xl shadow-md flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex-1">
            <span class="inline-block px-3 py-1 rounded-full bg-blue-700 text-blue-100 text-xs font-bold mb-3">
                <i class="fa-solid fa-location-dot mr-1"></i> Sistem Geofence Aktif
            </span>
            <h2 class="text-2xl font-bold mt-0 tracking-tight">Presensi Berbasis GPS</h2>
            <p class="text-sm text-blue-100 mt-2 max-w-md">
                Validasi kehadiran berbasis GPS dan geofence radius kampus SMKN 1 Medelin.
            </p>
        </div>

        <div class="bg-white/10 p-6 rounded-2xl border border-white/20 text-center min-w-fit">
            <span class="text-xs text-blue-200 font-semibold uppercase block mb-2">Radius Geofence</span>
            <span class="text-3xl font-bold text-white block\">150 m</span>
            <span class="text-[10px] text-blue-300 block mt-2\">Lat: -6.40 | Lng: 106.84</span>
        </div>
    </div>

    <!-- Clock-in Widget & Subject Attendance -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Col: Live Clock In / Out Simulator -->
        <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between pb-4 border-b border-slate-200 mb-6">
                    <h3 class="font-bold text-slate-800 text-sm">Presensi Hari Ini</h3>
                    <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold whitespace-nowrap">Sel, 15 Sep</span>
                </div>

                <!-- Clock Display -->
                <div class="text-center py-8">
                    <h4 class="text-5xl font-bold text-slate-800 tracking-tight font-mono" id="liveClock">07:12:45</h4>
                    <p class="text-xs text-slate-500 font-medium mt-3">Waktu Indonesia Barat</p>
                </div>

                <!-- GPS Location Verification Card -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3 text-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 font-medium">Lokasi:</span>
                        <span class="font-bold text-slate-800">{{ $schoolGeofence['name'] }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 font-medium">Jarak:</span>
                        <span class="font-bold text-slate-800">24.5 m (Valid)</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 font-medium">Akurasi:</span>
                        <span class="font-bold text-blue-600"><i class="fa-solid fa-check-circle mr-1\"></i>High Precision</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-8">
                <button class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition-colors flex items-center justify-center gap-2 cursor-default">
                    <i class="fa-solid fa-check-circle"></i> Jam Datang (07:12 WIB)
                </button>
            </div>
        </div>

        <!-- Right 2 Cols: Subject Attendance & History -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Subject Attendance Table -->
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-800 text-base mb-6">Presensi Per Mata Pelajaran</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-slate-200 text-slate-500 font-semibold uppercase text-xs">
                                <th class="pb-4">Mata Pelajaran</th>
                                <th class="pb-4">Waktu</th>
                                <th class="pb-4">Pengajar</th>
                                <th class="pb-4 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($subjectAttendance as $sub)
                            <tr>
                                <td class="py-4 font-bold text-slate-800">{{ $sub['subject'] }}</td>
                                <td class="py-4 text-slate-600">{{ $sub['time'] }}</td>
                                <td class="py-4 text-slate-600 font-medium">{{ $sub['teacher'] }}</td>
                                <td class="py-4 text-right">
                                    @if(str_contains($sub['status'], 'Hadir'))
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-100 text-blue-700 font-semibold text-xs">
                                            <i class="fa-solid fa-check-circle"></i> {{ $sub['status'] }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100 text-slate-600 font-semibold text-xs">
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
            <div class="bg-white rounded-2xl p-8 border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-800 text-base mb-6">Riwayat Kehadiran 5 Hari</h3>
                
                <div class="space-y-3">
                    @foreach($history as $h)
                    <div class="flex items-center justify-between p-4 rounded-xl bg-slate-50 border border-slate-200 text-sm">
                        <div class="flex items-center gap-3 flex-1">
                            <div class="w-8 h-8 rounded-lg bg-slate-200 text-slate-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-calendar text-xs"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800">{{ $h['day'] }}, {{ $h['date'] }}</h4>
                                <span class="text-xs text-slate-500">Datang: {{ $h['in'] }} • Pulang: {{ $h['out'] }}</span>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block px-3 py-1 rounded-lg text-xs font-semibold {{ $h['status'] === 'Hadir' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $h['status'] }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
