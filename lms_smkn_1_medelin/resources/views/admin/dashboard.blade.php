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

    <!-- =========================================================
         CBT MONITORING SECTION
         ========================================================= -->
    <div class="bg-slate-900 rounded-3xl overflow-hidden border border-slate-700 shadow-xl">

        <!-- CBT Header -->
        <div class="bg-gradient-to-r from-blue-900 to-indigo-900 p-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 rounded-full bg-blue-500/30 text-blue-300 text-xs font-bold border border-blue-400/30">
                    <i class="fa-solid fa-desktop mr-1"></i> Ujian Online CBT
                </span>
                <h3 class="text-xl font-black text-white mt-2">Monitoring Ujian Real-Time</h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    Data diperbarui otomatis setiap 5 detik &nbsp;•&nbsp; 
                    <span id="last-updated" class="text-blue-400 font-semibold">Memuat...</span>
                </p>
            </div>

            <!-- CBT Stats Ringkas -->
            <div class="flex flex-wrap gap-3">
                <div class="bg-blue-500/20 border border-blue-500/40 rounded-2xl px-4 py-2 text-center">
                    <p class="text-[10px] text-blue-300 font-bold uppercase">Sedang Ujian</p>
                    <p class="text-2xl font-black text-blue-300" id="stat-in-progress">{{ $cbtStats['in_progress'] }}</p>
                </div>
                <div class="bg-emerald-500/20 border border-emerald-500/40 rounded-2xl px-4 py-2 text-center">
                    <p class="text-[10px] text-emerald-300 font-bold uppercase">Selesai</p>
                    <p class="text-2xl font-black text-emerald-300" id="stat-completed">{{ $cbtStats['completed'] }}</p>
                </div>
                <div class="bg-red-500/20 border border-red-500/40 rounded-2xl px-4 py-2 text-center">
                    <p class="text-[10px] text-red-300 font-bold uppercase">Auto-Submit</p>
                    <p class="text-2xl font-black text-red-300" id="stat-auto">{{ $cbtStats['auto_submitted'] }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="p-5 bg-slate-800/50 border-b border-slate-700 flex flex-col sm:flex-row gap-3">
            <!-- Filter Ujian -->
            <select id="filter-quiz" onchange="loadMonitoring()"
                class="flex-1 px-4 py-2.5 rounded-xl bg-slate-700 border border-slate-600 text-slate-200 text-sm font-medium focus:outline-none focus:border-blue-500">
                <option value="">Semua Ujian</option>
                <!-- Diisi oleh JS -->
            </select>

            <!-- Filter Kelas -->
            <select id="filter-kelas" onchange="loadMonitoring()"
                class="w-full sm:w-48 px-4 py-2.5 rounded-xl bg-slate-700 border border-slate-600 text-slate-200 text-sm font-medium focus:outline-none focus:border-blue-500">
                <option value="">Semua Kelas</option>
                <!-- Diisi oleh JS -->
            </select>

            <!-- Cari Nama -->
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" id="filter-search" placeholder="Cari nama siswa..." oninput="debounceSearch()"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-700 border border-slate-600 text-slate-200 text-sm font-medium focus:outline-none focus:border-blue-500 placeholder-slate-500">
            </div>

            <!-- Refresh Manual -->
            <button onclick="loadMonitoring()" title="Refresh"
                class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition-all">
                <i class="fa-solid fa-rotate-right"></i>
            </button>
        </div>

        <!-- Tabel Monitoring -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-800 text-slate-400 text-[11px] uppercase tracking-wider border-b border-slate-700">
                        <th class="p-4 font-bold">Nama Siswa</th>
                        <th class="p-4 font-bold">Kelas</th>
                        <th class="p-4 font-bold">Ujian</th>
                        <th class="p-4 font-bold">Status</th>
                        <th class="p-4 font-bold text-center">Pelanggaran</th>
                        <th class="p-4 font-bold text-center">Deteksi Keluar Tab</th>
                        <th class="p-4 font-bold text-center">Nilai</th>
                        <th class="p-4 font-bold">Mulai</th>
                        <th class="p-4 font-bold">Submit</th>
                        <th class="p-4 font-bold text-center">Log</th>
                        <th class="p-4 font-bold text-center">Aksi / Rincian</th>
                    </tr>
                </thead>
                <tbody id="monitoring-tbody" class="divide-y divide-slate-800">
                    <tr>
                        <td colspan="9" class="p-8 text-center">
                            <div class="flex items-center justify-center gap-2 text-slate-500 text-sm">
                                <i class="fa-solid fa-spinner animate-spin"></i> Memuat data...
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Tabel -->
        <div class="p-4 bg-slate-800/30 border-t border-slate-700 flex items-center justify-between text-xs text-slate-500">
            <span id="total-records">0 sesi ujian</span>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                <span>Live monitoring aktif</span>
            </div>
        </div>
    </div>

    <!-- Modal Log Pelanggaran -->
    <div id="violation-log-modal" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 p-4">
        <div class="bg-slate-900 rounded-3xl max-w-lg w-full border border-slate-700 shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-red-900 to-slate-900 p-6 flex items-center justify-between">
                <div>
                    <h4 class="text-lg font-black text-white">Log Pelanggaran</h4>
                    <p class="text-xs text-slate-400 mt-0.5" id="violation-modal-student">-</p>
                </div>
                <button onclick="closeViolationModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
            <div class="p-6 max-h-96 overflow-y-auto" id="violation-log-body">
                <!-- Diisi JS -->
            </div>
        </div>
    </div>

    <!-- Grid: Daftar Siswa + Tugas Menunggak -->
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

<script>
// =====================================================
// ADMIN CBT MONITORING — POLLING REAL-TIME
// =====================================================

const VIOLATION_TYPE_LABELS = {
    'tab_switch':        'Pindah Tab / Browser',
    'window_blur':       'Jendela Tidak Aktif',
    'page_hide':         'Halaman Disembunyikan',
    'keyboard_shortcut': 'Shortcut Keyboard Terlarang',
    'dev_tools':         'DevTools Terdeteksi',
};

let pollingTimer   = null;
let searchTimer    = null;
let cachedSessions = [];

// Jalankan pertama kali saat halaman siap
document.addEventListener('DOMContentLoaded', () => {
    loadMonitoring();
    startPolling();
});

// ─── Polling ─────────────────────────────────────────────────────────

function startPolling() {
    if (pollingTimer) clearInterval(pollingTimer);
    pollingTimer = setInterval(loadMonitoring, 5000); // tiap 5 detik
}

function debounceSearch() {
    if (searchTimer) clearTimeout(searchTimer);
    searchTimer = setTimeout(loadMonitoring, 500);
}

// ─── Load Data ───────────────────────────────────────────────────────

function loadMonitoring() {
    const quizId  = document.getElementById('filter-quiz').value;
    const kelas   = document.getElementById('filter-kelas').value;
    const search  = document.getElementById('filter-search').value;

    const params = new URLSearchParams();
    if (quizId) params.append('quiz_id', quizId);
    if (kelas)  params.append('kelas', kelas);
    if (search) params.append('search', search);

    fetch(`/admin/cbt/monitoring?${params.toString()}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        cachedSessions = data.sessions;
        renderTable(data.sessions);
        populateFilters(data.quizList, data.kelasList);
        updateStats(data.sessions);
        document.getElementById('last-updated').textContent = 'Diperbarui: ' + data.timestamp;
    })
    .catch(err => {
        console.error('Polling error:', err);
        document.getElementById('last-updated').textContent = 'Gagal memuat — retrying...';
    });
}

// ─── Render Tabel ────────────────────────────────────────────────────

function renderTable(sessions) {
    const tbody = document.getElementById('monitoring-tbody');
    document.getElementById('total-records').textContent = `${sessions.length} sesi ujian`;

    if (!sessions.length) {
        tbody.innerHTML = `
            <tr>
                <td colspan="9" class="p-10 text-center text-slate-500 text-sm">
                    <i class="fa-solid fa-inbox text-3xl block mb-2 text-slate-600"></i>
                    Belum ada data sesi ujian
                </td>
            </tr>`;
        return;
    }

    tbody.innerHTML = sessions.map(s => {
        const statusBadge = renderStatusBadge(s.status, s.status_label);
        const violBadge   = s.violation_count > 0
            ? `<span class="font-black text-${s.violation_count >= 3 ? 'red' : 'yellow'}-400">${s.violation_count}</span>`
            : `<span class="text-slate-500">0</span>`;
        
        // Deteksi Keluar Tab / Switch Tab Indikator yang JELAS
        const hasViolations = s.violation_count > 0;
        let tabViolBadge = '';
        let rowClass = 'hover:bg-slate-800/40 transition-colors border-b border-slate-800';

        if (s.violation_count >= 3) {
            rowClass = 'bg-red-950/30 hover:bg-red-950/50 border-b border-red-800/60 transition-colors';
            tabViolBadge = `
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-600/30 border border-red-500 text-red-200 text-xs font-black shadow-lg shadow-red-950/50 animate-pulse">
                    <i class="fa-solid fa-triangle-exclamation text-red-400"></i>
                    <span>Keluar Tab: ${s.violation_count}x (KICKED)</span>
                </div>
            `;
        } else if (s.violation_count > 0) {
            rowClass = 'bg-amber-950/20 hover:bg-amber-950/40 border-b border-amber-800/40 transition-colors';
            tabViolBadge = `
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 text-xs font-bold">
                    <i class="fa-solid fa-bell text-amber-400"></i>
                    <span>Keluar Tab: ${s.violation_count}x</span>
                </div>
            `;
        } else {
            tabViolBadge = `
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-semibold border border-emerald-500/20">
                    <i class="fa-solid fa-shield-check text-[10px]"></i> Tertib (0x)
                </span>
            `;
        }

        const scoreText = s.score !== null
            ? `<span class="font-black ${s.score >= 70 ? 'text-emerald-400' : 'text-red-400'}">${s.score}</span>`
            ? `<span class="font-black text-sm ${s.score >= 70 ? 'text-emerald-400' : 'text-red-400'}">${s.score}</span>`
            : `<span class="text-slate-500">-</span>`;
        const submitTime = s.submitted_at ?? '<span class="text-slate-500 italic">Belum</span>';

        return `
            <tr class="hover:bg-slate-800/40 transition-colors border-b border-slate-800">
            <tr class="${rowClass}">
                <td class="p-4">
                    <div class="font-bold text-white text-sm">${escHtml(s.student_name)}</div>
                    <div class="font-bold text-white text-sm flex items-center gap-2">
                        <span>${escHtml(s.student_name)}</span>
                        ${s.violation_count >= 3 ? '<span class="px-1.5 py-0.5 rounded text-[10px] bg-red-500 text-white font-extrabold uppercase tracking-wider">Locked</span>' : ''}
                    </div>
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded-lg bg-indigo-500/20 text-indigo-300 text-xs font-bold border border-indigo-500/30">
                        ${escHtml(s.student_kelas)}
                    </span>
                </td>
                <td class="p-4">
                    <div class="text-sm text-slate-200 font-semibold">${escHtml(s.exam_title)}</div>
                    <div class="text-[10px] text-slate-500 mt-0.5">${escHtml(s.exam_code)}</div>
                </td>
                <td class="p-4">${statusBadge}</td>
                <td class="p-4 text-center">${violBadge}</td>
                <td class="p-4 text-center">${tabViolBadge}</td>
                <td class="p-4 text-center">${scoreText}</td>
                <td class="p-4 text-xs text-slate-400 font-mono">${s.started_at ?? '-'}</td>
                <td class="p-4 text-xs text-slate-400 font-mono">${submitTime}</td>
                <td class="p-4 text-center">
                    ${s.violations.length > 0
                        ? `<button onclick='showViolationLog(${JSON.stringify(s)})'
                                class="px-3 py-1.5 rounded-lg bg-red-900/40 hover:bg-red-900/70 text-red-300 text-xs font-bold border border-red-700/40 transition-all">
                                <i class="fa-solid fa-list mr-1"></i>${s.violations.length}
                                class="px-3 py-1.5 rounded-xl bg-red-600/20 hover:bg-red-600/40 text-red-300 text-xs font-bold border border-red-500/40 transition-all flex items-center justify-center gap-1.5 mx-auto">
                                <i class="fa-solid fa-eye"></i>
                                <span>Rincian (${s.violations.length})</span>
                            </button>`
                        : `<span class="text-slate-600 text-xs">-</span>`
                    }
                </td>
            </tr>`;
    }).join('');
}

function renderStatusBadge(status, label) {
    const colorMap = {
        'in_progress'   : 'bg-blue-500/20 text-blue-300 border-blue-500/40',
        'completed'     : 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
        'auto_submitted': 'bg-red-500/20 text-red-300 border-red-500/40',
        'timeout'       : 'bg-amber-500/20 text-amber-300 border-amber-500/40',
    };
    const iconMap = {
        'in_progress'   : 'fa-circle-notch fa-spin',
        'completed'     : 'fa-check-circle',
        'auto_submitted': 'fa-lock',
        'timeout'       : 'fa-hourglass-end',
    };
    const cls  = colorMap[status] ?? 'bg-slate-500/20 text-slate-300 border-slate-500/40';
    const icon = iconMap[status] ?? 'fa-question';
    return `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg border text-xs font-bold ${cls}">
        <i class="fa-solid ${icon}"></i>${label}
    </span>`;
}

// ─── Filter Options ──────────────────────────────────────────────────

function populateFilters(quizList, kelasList) {
    const quizSel  = document.getElementById('filter-quiz');
    const kelasSel = document.getElementById('filter-kelas');

    const selectedQuiz  = quizSel.value;
    const selectedKelas = kelasSel.value;

    quizSel.innerHTML = `<option value="">Semua Ujian</option>` +
        quizList.map(q => `<option value="${q.id}" ${q.id == selectedQuiz ? 'selected' : ''}>
            ${escHtml(q.title)} (${escHtml(q.code)})
        </option>`).join('');

    kelasSel.innerHTML = `<option value="">Semua Kelas</option>` +
        kelasList.map(k => `<option value="${k}" ${k === selectedKelas ? 'selected' : ''}>${escHtml(k)}</option>`).join('');
}

// ─── Stats Counter ────────────────────────────────────────────────────

function updateStats(sessions) {
    const inProgress  = sessions.filter(s => s.status === 'in_progress').length;
    const completed   = sessions.filter(s => ['completed','timeout'].includes(s.status)).length;
    const autoSubmit  = sessions.filter(s => s.status === 'auto_submitted').length;

    document.getElementById('stat-in-progress').textContent = inProgress;
    document.getElementById('stat-completed').textContent   = completed;
    document.getElementById('stat-auto').textContent        = autoSubmit;
}

// ─── Violation Log Modal ─────────────────────────────────────────────

function showViolationLog(session) {
    document.getElementById('violation-modal-student').textContent =
        `${session.student_name} · ${session.exam_title}`;

    const body = document.getElementById('violation-log-body');

    if (!session.violations.length) {
        body.innerHTML = `<p class="text-slate-500 text-sm text-center py-6">Tidak ada pelanggaran</p>`;
    } else {
        body.innerHTML = session.violations.map((v, i) => `
            <div class="flex items-start gap-3 p-3 rounded-2xl mb-2 ${v.warning_count >= 3 ? 'bg-red-900/30 border border-red-700/40' : 'bg-slate-800 border border-slate-700'}">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center font-black text-sm flex-shrink-0 ${v.warning_count >= 3 ? 'bg-red-700 text-white' : 'bg-yellow-500/20 text-yellow-400'}">
                    ${v.warning_count}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-white">Peringatan ${v.warning_count}/3</p>
                    <p class="text-xs text-slate-400 mt-0.5">${VIOLATION_TYPE_LABELS[v.type] ?? v.type}</p>
                </div>
                <div class="text-xs font-mono text-slate-500">${v.recorded_at}</div>
            </div>
        `).join('');
    }

    document.getElementById('violation-log-modal').classList.remove('hidden');
}

function closeViolationModal() {
    document.getElementById('violation-log-modal').classList.add('hidden');
}

// ─── Helpers ─────────────────────────────────────────────────────────

function escHtml(str) {
    if (!str) return '-';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}
</script>
@endsection
