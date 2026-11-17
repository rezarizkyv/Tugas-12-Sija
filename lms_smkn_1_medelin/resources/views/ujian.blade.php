@extends('layouts.app')

@section('title', 'Sistem Ujian Online - SMKN 1 Medelin')

@section('content')
<div id="exam-container" class="space-y-8">

    <!-- EXAM LIST VIEW -->
    <div id="exam-list-view" class="space-y-6">
        
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-800 to-blue-900 text-white p-8 rounded-3xl shadow-lg flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
            <div class="absolute right-0 bottom-0 w-64 h-64 bg-white/5 rounded-full blur-2xl"></div>
            <div class="relative z-10">
                <span class="px-3 py-1 rounded-full bg-blue-500/30 text-blue-300 text-xs font-bold border border-blue-400/30">
                    <i class="fa-solid fa-shield-halved animate-pulse mr-1"></i> Sistem Ujian Terenkripsi
                </span>
                <h2 class="text-3xl font-bold mt-2 tracking-tight">Ujian Online Aman (CBT)</h2>
                <p class="text-xs text-blue-100 mt-1 max-w-xl">
                    Sistem penilaian komputerisasi dengan proteksi anti-curang dan monitoring real-time.
                </p>
            </div>
        </div>

        <!-- Available Exams Grid -->
        <div class="space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Daftar Ujian Tersedia</h3>

            @if($exams->isEmpty())
            <div class="bg-white rounded-3xl p-8 border border-slate-200 text-center">
                <i class="fa-solid fa-inbox text-4xl text-slate-300 mb-3 block"></i>
                <p class="text-slate-600 font-medium">Belum ada ujian yang tersedia saat ini</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($exams as $exam)
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col">
                    
                    <!-- Card Header -->
                    <div class="bg-gradient-to-r from-blue-50 to-slate-50 p-6 border-b border-slate-100">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 class="text-lg font-bold text-slate-800 leading-snug">{{ $exam->title }}</h4>
                                <p class="text-xs text-slate-500 mt-1">
                                    <i class="fa-solid fa-book mr-1"></i> {{ optional($exam->course)->title ?? 'Tanpa Mata Pelajaran' }}
                                </p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-700 text-[10px] font-bold whitespace-nowrap">
                                {{ $exam->code }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 flex-1">
                        <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                            {{ $exam->description ?? 'Tidak ada deskripsi' }}
                        </p>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-100 text-center text-xs mb-4">
                            <div>
                                <span class="text-slate-500 text-[10px] block font-medium mb-1">Durasi</span>
                                <span class="font-bold text-slate-800 text-sm">{{ $exam->duration_minutes }} Min</span>
                            </div>
                            <div class="border-l border-slate-200">
                                <span class="text-slate-500 text-[10px] block font-medium mb-1">Soal</span>
                                <span class="font-bold text-slate-800 text-sm">{{ count($exam->questions) }}</span>
                            </div>
                            <div class="border-l border-slate-200">
                                <span class="text-slate-500 text-[10px] block font-medium mb-1">Status</span>
                                @if($exam->status === 'active')
                                    <span class="font-bold text-emerald-600 text-sm">Aktif</span>
                                @elseif($exam->status === 'upcoming')
                                    <span class="font-bold text-amber-600 text-sm">Jadwal</span>
                                @else
                                    <span class="font-bold text-slate-500 text-sm">Selesai</span>
                                @endif
                            </div>
                        </div>

                        <!-- Security Badge -->
                        <div class="p-3 rounded-2xl bg-blue-50 border border-blue-200 flex items-start gap-2">
                            <i class="fa-solid fa-lock text-blue-600 mt-0.5 text-xs flex-shrink-0"></i>
                            <p class="text-xs text-blue-700 font-medium">
                                {{ $exam->is_secure_mode ? 'Mode Aman Aktif - Tab switching terdeteksi' : 'Mode Normal' }}
                            </p>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="p-6 pt-0 border-t border-slate-100">
                        @if($exam->status === 'active')
                            <button onclick="openExamPreview({{ $exam->id }}, '{{ addslashes($exam->title) }}')" class="w-full py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition-all flex items-center justify-center gap-2 shadow-md shadow-blue-600/20">
                                <i class="fa-solid fa-play-circle"></i> Mulai Ujian
                            </button>
                        @elseif($exam->status === 'upcoming')
                            <button disabled class="w-full py-3 rounded-2xl bg-slate-100 text-slate-400 font-bold text-sm cursor-not-allowed">
                                <i class="fa-solid fa-clock"></i> Belum Waktunya
                            </button>
                        @else
                            <button class="w-full py-3 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition-all">
                                <i class="fa-solid fa-eye"></i> Lihat Hasil
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- EXAM PREVIEW MODAL -->
    <div id="exam-preview-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-40 p-4">
        <div class="bg-white rounded-3xl max-w-md w-full shadow-2xl overflow-hidden">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-6">
                <h3 class="text-xl font-bold">Konfirmasi Mulai Ujian</h3>
                <p class="text-xs text-blue-100 mt-1">Baca informasi penting di bawah</p>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div>
                    <p class="text-sm text-slate-600 font-medium mb-2">Ujian:</p>
                    <p class="text-base font-bold text-slate-800" id="preview-exam-title">-</p>
                </div>

                <!-- Security Notice -->
                <div class="p-4 rounded-2xl bg-red-50 border border-red-200">
                    <p class="text-xs font-bold text-red-700 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i> PERHATIAN PENTING
                    </p>
                    <ul class="text-xs text-red-700 space-y-1.5 font-medium">
                        <li class="flex gap-2"><span class="flex-shrink-0">•</span> <span>Mode proteksi akan aktif saat ujian dimulai</span></li>
                        <li class="flex gap-2"><span class="flex-shrink-0">•</span> <span>Dilarang berpindah tab atau jendela browser</span></li>
                        <li class="flex gap-2"><span class="flex-shrink-0">•</span> <span>Peringatan ke-3 = ujian otomatis dikumpulkan</span></li>
                        <li class="flex gap-2"><span class="flex-shrink-0">•</span> <span>Semua pelanggaran akan dicatat dan dilaporkan</span></li>
                    </ul>
                </div>

                <!-- Consent Checkbox -->
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <input type="checkbox" id="exam-consent" class="w-4 h-4 mt-0.5 rounded border-slate-300 text-blue-600 focus:ring-0">
                    <label for="exam-consent" class="text-xs text-slate-700 font-medium">
                        Saya memahami dan siap mengerjakan ujian dengan sistem keamanan yang ketat
                    </label>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-6 border-t border-slate-200 flex gap-3">
                <button onclick="closeExamPreview()" class="flex-1 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition-all">
                    Batal
                </button>
                <button onclick="startExam()" class="flex-1 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition-all" id="start-exam-btn" disabled>
                    Mulai Ujian
                </button>
            </div>
        </div>
    </div>

    <!-- EXAM ROOM VIEW -->
    <div id="exam-room-view" style="display: none;" class="space-y-6">
        
        <!-- Top Control Bar -->
        <div class="bg-slate-900 text-white p-4 rounded-2xl shadow-lg flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-sm font-bold">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <p class="font-bold text-sm">Sistem Proteksi Aktif</p>
                    <p class="text-xs text-slate-300">Monitoring tab switch: <span id="warning-counter" class="text-yellow-400 font-bold">0</span>/3</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <!-- Timer -->
                <div class="px-4 py-2 rounded-xl bg-slate-800 border border-slate-700 flex items-center gap-2 text-sm font-bold">
                    <i class="fa-regular fa-hourglass-end text-blue-400"></i>
                    <span id="timer" class="text-slate-100">--:--</span>
                </div>

                <!-- Submit Button -->
                <button onclick="submitExam()" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition-all">
                    <i class="fa-solid fa-check-circle mr-1"></i> Selesai
                </button>
            </div>
        </div>

        <!-- Exam Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            
            <!-- Question Panel (Main) -->
            <div class="lg:col-span-3 bg-white rounded-3xl p-8 border border-slate-200 shadow-sm flex flex-col justify-between min-h-[500px]">
                
                <!-- Question Header -->
                <div>
                    <div class="flex items-center justify-between pb-6 border-b border-slate-200 mb-6">
                        <div>
                            <span class="inline-block px-3 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold mb-2">
                                Soal <span id="q-number">1</span> dari <span id="total-questions">10</span>
                            </span>
                            <p class="text-sm text-slate-500 font-medium mt-1">Pilih satu jawaban yang paling tepat</p>
                        </div>
                        <button onclick="toggleDoubtful()" class="px-3 py-1 rounded-xl text-xs font-bold border transition-all" id="doubtful-btn" style="background-color: #f1f5f9; color: #64748b; border-color: #e2e8f0;">
                            <i class="fa-solid fa-bookmark mr-1"></i> Tandai Ragu
                        </button>
                    </div>

                    <!-- Question Text -->
                    <div class="mb-6">
                        <p class="text-base font-semibold text-slate-800 leading-relaxed" id="question-text">
                            Memuat soal...
                        </p>
                    </div>

                    <!-- Options -->
                    <div id="options-container" class="space-y-3">
                        <!-- Options will be generated here -->
                    </div>
                </div>

                <!-- Navigation -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-200 mt-8">
                    <button onclick="previousQuestion()" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all flex items-center gap-2">
                        <i class="fa-solid fa-chevron-left"></i> Sebelumnya
                    </button>
                    <button onclick="nextQuestion()" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-all flex items-center gap-2">
                        Selanjutnya <i class="fa-solid fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Sidebar: Question Map -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm h-fit sticky top-4">
                <h4 class="font-bold text-slate-800 text-sm mb-4 pb-3 border-b border-slate-200">Peta Soal</h4>
                
                <div id="question-map" class="grid grid-cols-5 gap-2 mb-6">
                    <!-- Question buttons generated here -->
                </div>

                <div class="space-y-2 text-[11px] text-slate-600 mb-4 pb-4 border-b border-slate-200">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span class="font-medium">Dijawab</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span class="font-medium">Ragu</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                        <span class="font-medium">Belum dijawab</span>
                    </div>
                </div>

                <button onclick="exitExam()" class="w-full py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-all">
                    <i class="fa-solid fa-sign-out-alt mr-1"></i> Keluar
                </button>
            </div>
        </div>
    </div>

    <!-- =====================================================
         [NEW] WARNING MODAL — PERINGATAN 1 & 2
         Tampil modal informatif untuk peringatan ke-1 dan ke-2
         ===================================================== -->
    <div id="warning-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-[9998]">
        <div class="bg-slate-900 rounded-3xl max-w-sm mx-4 shadow-2xl border-2 border-yellow-500 overflow-hidden animate-bounce-once">
            <!-- Header -->
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white p-6 text-center">
                <i class="fa-solid fa-triangle-exclamation text-3xl mb-2 block"></i>
                <h3 class="text-2xl font-black">PERINGATAN!</h3>
                <p class="text-xs text-yellow-100 mt-1 font-semibold" id="warning-modal-subtitle">Anda Meninggalkan Jendela Ujian</p>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4">
                <!-- Counter -->
                <div class="text-center p-4 rounded-2xl bg-yellow-500/10 border border-yellow-500/40">
                    <p class="text-xs text-yellow-300 font-semibold mb-1">PERINGATAN KE:</p>
                    <p class="text-5xl font-black text-yellow-400" id="warning-display">1</p>
                    <p class="text-xs text-yellow-300 font-semibold mt-1">dari 3 Peringatan</p>
                </div>

                <!-- Jenis Pelanggaran -->
                <div class="p-3 rounded-2xl bg-slate-800 border border-slate-700">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Jenis Pelanggaran</p>
                    <p class="text-sm font-bold text-white" id="warning-violation-type">Pindah tab / Jendela tidak aktif</p>
                </div>

                <!-- Reminder -->
                <div class="p-4 rounded-2xl bg-red-900/40 border border-red-500/40">
                    <p class="text-xs text-red-300 font-bold mb-2">⚠️ INGAT:</p>
                    <ul class="text-xs text-red-200 space-y-1 font-medium">
                        <li class="flex gap-2"><span>•</span> <span>Peringatan ke-3 = Ujian dikumpulkan otomatis</span></li>
                        <li class="flex gap-2"><span>•</span> <span>Jawaban yang sudah ada TETAP akan dinilai</span></li>
                        <li class="flex gap-2"><span>•</span> <span>Pelanggaran akan dilaporkan ke guru</span></li>
                    </ul>
                </div>

                <!-- Close Button (hanya untuk warning 1 & 2) -->
                <button id="warning-close-btn" onclick="closeWarningModal()" 
                    class="w-full py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-black text-sm transition-all">
                    <i class="fa-solid fa-rotate-left mr-1"></i> Kembali ke Ujian
                </button>
            </div>
        </div>
    </div>

    <!-- =====================================================
         [NEW] KICKED MODAL — PERINGATAN KE-3 (BAHAYA)
         Modal merah khusus untuk auto-submit karena pelanggaran ke-3
         ===================================================== -->
    <div id="kicked-modal" class="hidden fixed inset-0 bg-black/80 backdrop-blur-md flex items-center justify-center z-[9999]">
        <div class="bg-slate-900 rounded-3xl max-w-sm mx-4 shadow-2xl border-2 border-red-600 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-700 to-red-800 text-white p-8 text-center">
                <div class="w-20 h-20 rounded-full bg-red-900/60 border-4 border-red-400 flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-lock text-4xl text-red-300"></i>
                </div>
                <h2 class="text-2xl font-black">UJIAN DIHENTIKAN</h2>
                <p class="text-sm text-red-200 mt-1 font-bold">Peringatan Ke-3 — Auto Submit Aktif</p>
            </div>

            <!-- Body -->
            <div class="p-6 space-y-4 text-center">
                <div class="p-4 rounded-2xl bg-red-900/30 border border-red-600/50">
                    <p class="text-sm font-black text-red-300 mb-2">
                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                        Ujian Dikumpulkan Otomatis
                    </p>
                    <p class="text-xs text-red-200 leading-relaxed">
                        Anda telah meninggalkan jendela ujian sebanyak <strong>3 kali</strong>. 
                        Sistem keamanan telah mengumpulkan ujian Anda secara otomatis.
                    </p>
                </div>

                <div class="p-4 rounded-2xl bg-blue-900/30 border border-blue-600/40">
                    <p class="text-xs text-blue-300 font-medium leading-relaxed">
                        <i class="fa-solid fa-info-circle mr-1"></i> 
                        Jawaban yang sudah Anda kerjakan tetap akan dinilai. 
                        Seluruh pelanggaran telah dicatat dan dilaporkan ke guru/admin.
                    </p>
                </div>

                <div id="kicked-countdown" class="text-sm font-bold text-slate-400">
                    Menutup otomatis dalam <span id="kicked-counter-num" class="text-white">5</span> detik...
                </div>

                <button onclick="goBackToList()" 
                    class="w-full py-3 rounded-2xl bg-slate-700 hover:bg-slate-600 text-white font-bold text-sm transition-all">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar Ujian
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Load Lock Mode Library (FIXED v2) -->
<script src="{{ asset('js/exam-lock-mode.js') }}"></script>

<script>
// ==================== META TOKEN ====================
const CSRF_TOKEN = '{{ csrf_token() }}';

// ==================== VIOLATION TYPE LABELS ====================
const VIOLATION_LABELS = {
    'tab_switch':        'Pindah tab / browser',
    'window_blur':       'Jendela tidak aktif / fokus hilang',
    'page_hide':         'Halaman disembunyikan',
    'keyboard_shortcut': 'Shortcut keyboard terlarang',
    'dev_tools':         'Kemungkinan DevTools dibuka',
    'unknown':           'Pelanggaran sistem',
};

// ==================== EXAM STATE ====================
const examState = {
    currentExam:     null,
    questions:       [],
    currentQuestion: 0,
    answers:         {},
    doubtful:        {},
    lockMode:        null,     // [FIX #1] instance ExamLockMode, di-reset tiap sesi
    examActive:      false,
    warningCount:    0,
    maxWarnings:     3,
    timerInterval:   null,
    timeRemaining:   0,
};

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', function() {
    console.log('✓ Exam page loaded');
    
    document.getElementById('exam-consent').addEventListener('change', function() {
        document.getElementById('start-exam-btn').disabled = !this.checked;
    });
});

// ==================== EXAM PREVIEW ====================
function openExamPreview(examId, examTitle) {
    const exams = @json($exams);
    const exam  = exams.find(e => e.id === examId);
    if (!exam) return;

    window.selectedExam = exam;
    document.getElementById('preview-exam-title').textContent = examTitle;
    document.getElementById('exam-preview-modal').classList.remove('hidden');
}

function closeExamPreview() {
    document.getElementById('exam-preview-modal').classList.add('hidden');
    document.getElementById('exam-consent').checked = false;
    document.getElementById('start-exam-btn').disabled = true;
    window.selectedExam = null;
}

// ==================== START EXAM ====================
function startExam() {
    const exam = window.selectedExam;
    if (!exam) return;

    // ── Reset state untuk sesi baru ──────────────────────────────────
    examState.currentExam     = exam;
    examState.questions       = exam.questions || [];
    examState.currentQuestion = 0;
    examState.answers         = {};
    examState.doubtful        = {};
    examState.warningCount    = 0;   // [FIX #1] reset counter pelanggaran

    if (!examState.questions.length) {
        alert('Ujian tidak memiliki soal!');
        return;
    }

    closeExamPreview();

    // Switch view
    document.getElementById('exam-list-view').style.display  = 'none';
    document.getElementById('exam-room-view').style.display  = 'block';

    // [FIX #1] Destroy instance lama lalu buat yang baru — cegah listener menumpuk
    initializeLockMode();
    examState.lockMode.setExamActive(true);
    examState.examActive = true;

    // Reset counter display
    document.getElementById('warning-counter').textContent = '0';

    // Render
    renderQuestion();
    renderQuestionMap();
    startTimer();

    // Kirim log "start" ke server
    logExamEvent(exam.id, 'start', 'Ujian dimulai');

    console.log('✓ Exam started:', exam.title, 'with', examState.questions.length, 'questions');
}

// ==================== LOCK MODE ====================
/**
 * [FIX #1] Selalu destroy instance lama dan buat baru.
 * Ini mencegah listener menumpuk antar sesi ujian.
 */
function initializeLockMode() {
    // Jika ada instance lama, cabut semua listenernya dulu
    if (examState.lockMode) {
        examState.lockMode.destroyEventListeners();
        examState.lockMode = null;
    }

    examState.lockMode = new ExamLockMode({
        maxWarnings: examState.maxWarnings,
        // [FIX #2] onWarning dipanggil untuk SEMUA level (1, 2, dan 3)
        onWarning: (data) => handleWarning(data),
        onLocked:  (data) => handleKicked(data),
    });
}

/**
 * [FIX #2] handleWarning sekarang membedakan modal peringatan 1-2 vs ke-3.
 */
function handleWarning(data) {
    console.warn('⚠️ Warning #' + data.count, data.type);

    examState.warningCount = data.count;
    document.getElementById('warning-counter').textContent = data.count;

    // Tentukan label jenis pelanggaran
    const violationLabel = VIOLATION_LABELS[data.type] || VIOLATION_LABELS['unknown'];

    if (data.count < examState.maxWarnings) {
        // ── Peringatan 1 atau 2: tampilkan modal kuning ──────────────
        document.getElementById('warning-display').textContent        = data.count;
        document.getElementById('warning-violation-type').textContent = violationLabel;
        document.getElementById('warning-modal-subtitle').textContent = `Peringatan ${data.count}/3 — ${violationLabel}`;
        document.getElementById('warning-modal').classList.remove('hidden');

        // Auto-hide setelah 7 detik jika siswa sudah kembali
        setTimeout(() => {
            if (examState.examActive && !examState.lockMode.isLocked) {
                document.getElementById('warning-modal').classList.add('hidden');
            }
        }, 7000);
    } else {
        // ── Peringatan ke-3: tampilkan modal merah bahaya ──────────
        // Modal kicked ditampilkan oleh handleKicked()
        // — handleWarning untuk count=3 adalah sinyal bahwa onLocked akan menyusul
        // Tapi kita tampilkan kicked-modal dari sini juga untuk responsivitas
        document.getElementById('warning-modal').classList.add('hidden');
    }

    // Kirim pelanggaran ke server
    sendViolationToServer(data);
}

function handleKicked(data) {
    console.error('🔒 KICKED — Max warnings exceeded');

    examState.examActive = false;
    examState.lockMode.setExamActive(false);

    // Sembunyikan warning modal, tampilkan kicked modal
    document.getElementById('warning-modal').classList.add('hidden');
    document.getElementById('kicked-modal').classList.remove('hidden');

    // Countdown auto-redirect
    let countdown = 5;
    document.getElementById('kicked-counter-num').textContent = countdown;
    const countdownInterval = setInterval(() => {
        countdown--;
        document.getElementById('kicked-counter-num').textContent = countdown;
        if (countdown <= 0) {
            clearInterval(countdownInterval);
            autoSubmitExam(true); // true = auto-submit karena pelanggaran
        }
    }, 1000);

    // Auto-submit langsung (tidak tunggu countdown)
    autoSubmitExam(true);
}

function closeWarningModal() {
    document.getElementById('warning-modal').classList.add('hidden');
}

// ==================== SERVER COMMUNICATION ====================
function sendViolationToServer(data) {
    if (!examState.currentExam) return;

    fetch(`/ujian/${examState.currentExam.id}/violation`, {
        method:  'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        body: JSON.stringify({
            quiz_id:        examState.currentExam.id,
            violation_type: data.type,
            warning_count:  data.count,
        }),
    })
    .then(r => r.json())
    .then(res => console.log('✓ Violation logged:', res))
    .catch(err => console.error('✗ Failed to log violation:', err));
}

function logExamEvent(quizId, eventType, details) {
    fetch(`/ujian/${quizId}/log-event`, {
        method:  'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        body: JSON.stringify({ event_type: eventType, details }),
    }).catch(err => console.error('Failed to log event:', err));
}

// ==================== QUESTION RENDERING ====================
function renderQuestion() {
    if (!examState.questions[examState.currentQuestion]) return;

    const q         = examState.questions[examState.currentQuestion];
    const qIndex    = examState.currentQuestion;
    const isDoubtful = examState.doubtful[qIndex] || false;

    document.getElementById('q-number').textContent         = qIndex + 1;
    document.getElementById('total-questions').textContent  = examState.questions.length;

    // Doubtful button
    const btn = document.getElementById('doubtful-btn');
    if (isDoubtful) {
        btn.style.backgroundColor = '#fbbf24';
        btn.style.color           = '#78350f';
        btn.style.borderColor     = '#f59e0b';
        btn.innerHTML             = '<i class="fa-solid fa-bookmark mr-1"></i> Ragu (Ditandai)';
    } else {
        btn.style.backgroundColor = '#f1f5f9';
        btn.style.color           = '#64748b';
        btn.style.borderColor     = '#e2e8f0';
        btn.innerHTML             = '<i class="fa-solid fa-bookmark mr-1"></i> Tandai Ragu';
    }

    document.getElementById('question-text').textContent = q.question_text || 'Soal tidak tersedia';

    const container = document.getElementById('options-container');
    container.innerHTML = '';

    if (q.options && Array.isArray(q.options)) {
        q.options.forEach((option, idx) => {
            const label      = String.fromCharCode(65 + idx);
            const isSelected = examState.answers[qIndex] === label;

            const optBtn = document.createElement('button');
            optBtn.onclick   = () => selectAnswer(qIndex, label);
            optBtn.className = `w-full text-left p-4 rounded-2xl border transition-all text-sm flex items-start gap-3 ${
                isSelected
                    ? 'border-blue-600 bg-blue-50 font-bold'
                    : 'border-slate-200 bg-white hover:bg-slate-50'
            }`;
            optBtn.innerHTML = `
                <span class="w-6 h-6 rounded-lg ${isSelected ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-700'} flex items-center justify-center text-xs font-bold flex-shrink-0">${label}</span>
                <span class="text-slate-700">${option}</span>
            `;
            container.appendChild(optBtn);
        });
    }
}

function renderQuestionMap() {
    const container = document.getElementById('question-map');
    container.innerHTML = '';

    examState.questions.forEach((q, idx) => {
        const btn        = document.createElement('button');
        btn.onclick      = () => goToQuestion(idx);
        const isAnswered = examState.answers[idx] !== undefined;
        const isDoubtful = examState.doubtful[idx];
        const isCurrent  = examState.currentQuestion === idx;

        let bgClass = 'bg-slate-100 text-slate-700';
        if (isDoubtful)              bgClass = 'bg-amber-500 text-white';
        if (isAnswered && !isDoubtful) bgClass = 'bg-blue-600 text-white';

        btn.className  = `w-10 h-10 rounded-lg ${bgClass} font-bold text-xs flex items-center justify-center transition-all ${isCurrent ? 'ring-2 ring-offset-2 ring-blue-600' : ''}`;
        btn.textContent = idx + 1;
        container.appendChild(btn);
    });
}

// ==================== ANSWER HANDLING ====================
function selectAnswer(qIndex, answer) {
    examState.answers[qIndex] = answer;
    renderQuestion();
    renderQuestionMap();
}

function toggleDoubtful() {
    examState.doubtful[examState.currentQuestion] = !examState.doubtful[examState.currentQuestion];
    renderQuestion();
    renderQuestionMap();
}

function goToQuestion(qIndex) {
    examState.currentQuestion = qIndex;
    renderQuestion();
    renderQuestionMap();
}

function previousQuestion() {
    if (examState.currentQuestion > 0) {
        examState.currentQuestion--;
        renderQuestion();
        renderQuestionMap();
    }
}

function nextQuestion() {
    if (examState.currentQuestion < examState.questions.length - 1) {
        examState.currentQuestion++;
        renderQuestion();
        renderQuestionMap();
    }
}

// ==================== TIMER ====================
function startTimer() {
    if (examState.timerInterval) clearInterval(examState.timerInterval);

    const duration = examState.currentExam.duration_minutes * 60;
    examState.timeRemaining = duration;

    examState.timerInterval = setInterval(() => {
        if (!examState.examActive) {
            clearInterval(examState.timerInterval);
            return;
        }

        examState.timeRemaining--;

        const mins = Math.floor(examState.timeRemaining / 60);
        const secs = examState.timeRemaining % 60;
        const timerEl = document.getElementById('timer');

        timerEl.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;

        // Warning saat 5 menit tersisa
        if (examState.timeRemaining === 300) {
            timerEl.classList.add('text-yellow-400');
        }
        // Warning saat 1 menit tersisa
        if (examState.timeRemaining === 60) {
            timerEl.classList.remove('text-yellow-400');
            timerEl.classList.add('text-red-400');
        }

        if (examState.timeRemaining <= 0) {
            clearInterval(examState.timerInterval);
            autoSubmitExam(false); // false = auto-submit karena waktu habis
        }
    }, 1000);
}

// ==================== EXAM SUBMISSION ====================
function submitExam() {
    if (confirm('Apakah Anda yakin ingin mengumpulkan ujian?\n\nPastikan semua soal sudah dijawab.')) {
        autoSubmitExam(false);
    }
}

function autoSubmitExam(isViolation = false) {
    clearInterval(examState.timerInterval);
    examState.examActive = false;

    if (examState.lockMode) {
        examState.lockMode.setExamActive(false);
    }

    const submitReason = isViolation ? 'auto_violation' : 'manual_or_timeout';
    
    console.log('📝 Submitting exam:', {
        exam:     examState.currentExam?.title,
        answers:  examState.answers,
        answered: Object.keys(examState.answers).length,
        total:    examState.questions.length,
        reason:   submitReason,
    });

    // Kirim ke server
    fetch(`/ujian/${examState.currentExam.id}/submit`, {
        method:  'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': CSRF_TOKEN,
        },
        body: JSON.stringify({
            quiz_id:        examState.currentExam.id,
            answers:        examState.answers,
            submit_reason:  submitReason,
            violation_count: examState.warningCount,
        }),
    })
    .then(r => r.json())
    .then(res => {
        console.log('✓ Exam submitted:', res);
        if (!isViolation) {
            // Hanya kembali ke list jika bukan via kicked-modal
            // (kicked-modal punya tombolnya sendiri)
            goBackToList();
        }
    })
    .catch(err => {
        console.error('✗ Submit failed:', err);
        if (!isViolation) goBackToList();
    });
}

function goBackToList() {
    examState.examActive = false;
    if (examState.lockMode) {
        examState.lockMode.setExamActive(false);
        // [FIX #1] Destroy listeners saat keluar ujian
        examState.lockMode.destroyEventListeners();
        examState.lockMode = null;
    }

    clearInterval(examState.timerInterval);

    document.getElementById('exam-room-view').style.display = 'none';
    document.getElementById('exam-list-view').style.display = 'block';
    document.getElementById('warning-modal').classList.add('hidden');
    document.getElementById('kicked-modal').classList.add('hidden');
    document.getElementById('warning-counter').textContent = '0';

    // Reset timer display
    document.getElementById('timer').textContent = '--:--';
    document.getElementById('timer').className   = 'text-slate-100';
}

function exitExam() {
    if (confirm('Keluar dari ujian?\n\nJawaban yang sudah ada akan disimpan.')) {
        autoSubmitExam(false);
    }
}
</script>
@endsection
