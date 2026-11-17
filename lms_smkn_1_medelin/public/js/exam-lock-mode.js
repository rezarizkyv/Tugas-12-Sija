/**
 * ExamLockMode - Anti-Cheat Detection System (FIXED v2.0)
 *
 * PERBAIKAN dari v1.0:
 * - [FIX #1] Listener sekarang BISA di-destroy dan dipasang ulang (tidak menumpuk)
 * - [FIX #1] reset() kini membersihkan state locked + lastViolationTime dengan benar
 * - [FIX #1] initializeLockMode() di ujian.blade.php sekarang membuat instance BARU
 * - [FIX #1] Debounce naik ke 1500ms untuk cegah double-trigger visibilitychange + blur
 * - [FIX #2] onWarning dipanggil untuk SEMUA peringatan (1,2,3), logika kick dipisah
 */

class ExamLockMode {
    constructor(options = {}) {
        this.maxWarnings       = options.maxWarnings || 3;
        this.onWarning         = options.onWarning   || (() => {});
        this.onLocked          = options.onLocked    || (() => {});

        this.warningCount      = 0;
        this.isExamActive      = false;
        this.isLocked          = false;
        // [FIX #1] Jeda 1500ms mencegah visibilitychange + blur dihitung 2x
        this.debounceTime      = 1500;
        this.lastViolationTime = 0;

        // [FIX #1] Simpan referensi bound-handler agar bisa di-removeEventListener
        this._onVisibilityChange = () => this.handleVisibilityChange();
        this._onBlur             = () => this.handleBlur();
        this._onPageHide         = () => this.handlePageHide();
        this._onKeydown          = (e) => this.handleKeyboardShortcut(e);
        this._onContextMenu      = (e) => {
            if (this.isExamActive && !this.isLocked) e.preventDefault();
        };

        this._devToolsInterval = null;

        this.setupEventListeners();
        console.log('✓ ExamLockMode v2 initialized');
    }

    // ─── Setup / Teardown ──────────────────────────────────────────────────

    /**
     * [FIX #1] Pasang semua listener. Dipanggil sekali di constructor.
     */
    setupEventListeners() {
        document.addEventListener('visibilitychange', this._onVisibilityChange);
        window.addEventListener('blur',      this._onBlur);
        window.addEventListener('pagehide',  this._onPageHide);
        document.addEventListener('keydown', this._onKeydown);
        document.addEventListener('contextmenu', this._onContextMenu);

        this._devToolsInterval = setInterval(() => this._checkDevTools(), 2000);
    }

    /**
     * [FIX #1] Cabut semua listener. Panggil ini sebelum exam berikutnya
     * untuk menghindari listener menumpuk.
     */
    destroyEventListeners() {
        document.removeEventListener('visibilitychange', this._onVisibilityChange);
        window.removeEventListener('blur',      this._onBlur);
        window.removeEventListener('pagehide',  this._onPageHide);
        document.removeEventListener('keydown', this._onKeydown);
        document.removeEventListener('contextmenu', this._onContextMenu);

        if (this._devToolsInterval) {
            clearInterval(this._devToolsInterval);
            this._devToolsInterval = null;
        }
        console.log('🗑 ExamLockMode listeners removed');
    }

    // ─── Handlers ──────────────────────────────────────────────────────────

    handleVisibilityChange() {
        if (!this.isExamActive || this.isLocked) return;
        if (document.hidden) {
            console.warn('⚠️ Tab switched / window hidden');
            this.recordViolation('tab_switch');
        }
    }

    handleBlur() {
        if (!this.isExamActive || this.isLocked) return;
        console.warn('⚠️ Window lost focus');
        this.recordViolation('window_blur');
    }

    handlePageHide() {
        if (!this.isExamActive || this.isLocked) return;
        console.warn('⚠️ Page hidden / navigating away');
        this.recordViolation('page_hide');
    }

    handleKeyboardShortcut(e) {
        if (!this.isExamActive || this.isLocked) return;

        const isMac     = navigator.platform.toUpperCase().includes('MAC');
        const cmdKey    = isMac ? e.metaKey : e.ctrlKey;
        const shiftCmd  = e.shiftKey && cmdKey;

        const blocked = (
            e.key === 'F12'                    ||  // DevTools
            (e.key === 'I' && shiftCmd)        ||  // Ctrl+Shift+I
            (e.key === 'J' && shiftCmd)        ||  // Ctrl+Shift+J
            (e.key === 'C' && shiftCmd)        ||  // Ctrl+Shift+C
            (e.key === 'n' && cmdKey)          ||  // Ctrl+N (new window)
            (e.key === 't' && cmdKey)          ||  // Ctrl+T (new tab)
            (e.key === 'w' && cmdKey)              // Ctrl+W (close tab)
        );

        if (blocked) {
            e.preventDefault();
            console.warn('⚠️ Blocked shortcut:', e.key);
            this.recordViolation('keyboard_shortcut');
        }
    }

    _checkDevTools() {
        if (!this.isExamActive || this.isLocked) return;
        const diff = Math.abs(window.outerHeight - window.innerHeight);
        if (diff > 160) {
            this.recordViolation('dev_tools');
        }
    }

    // ─── Core Logic ────────────────────────────────────────────────────────

    /**
     * [FIX #1 + #2] recordViolation kini memanggil onWarning untuk SEMUA
     * warning level termasuk peringatan ke-3 sebelum memanggil lock().
     */
    recordViolation(type) {
        const now = Date.now();

        // [FIX #1] Debounce 1500ms – cegah visibilitychange + blur dihitung 2×
        if (now - this.lastViolationTime < this.debounceTime) {
            console.log('⏭ Violation debounced:', type);
            return;
        }
        this.lastViolationTime = now;

        if (this.isLocked) return;

        this.warningCount++;

        const violationData = {
            type:      type,
            count:     this.warningCount,
            timestamp: new Date().toISOString(),
        };

        console.warn(`⚠️ VIOLATION #${this.warningCount} (${type})`);

        // [FIX #2] Panggil onWarning untuk peringatan 1, 2, DAN 3
        // — sehingga blade bisa tampilkan modal yang berbeda untuk setiap level
        this.onWarning(violationData);

        // Setelah onWarning dipanggil, cek apakah perlu dikick
        if (this.warningCount >= this.maxWarnings) {
            // Beri jeda kecil agar modal #3 bisa ditampilkan dulu
            setTimeout(() => this.lock(violationData), 100);
        }
    }

    lock(data) {
        if (this.isLocked) return;
        this.isLocked = true;
        this.setExamActive(false);
        console.error('🔒 EXAM LOCKED — max warnings exceeded');
        this.onLocked(data);
    }

    // ─── Public API ────────────────────────────────────────────────────────

    setExamActive(active) {
        this.isExamActive = active;
        console.log(`${active ? '▶️' : '⏹️'} Exam monitoring: ${active ? 'ACTIVE' : 'INACTIVE'}`);
    }

    /**
     * [FIX #1] Reset penuh untuk sesi ujian baru.
     * Dipanggil sebelum startExam() agar counter kembali ke 0.
     */
    reset() {
        this.warningCount      = 0;
        this.isLocked          = false;
        this.lastViolationTime = 0;
        this.isExamActive      = false;
        console.log('🔄 ExamLockMode reset — ready for new session');
    }

    getWarningCount() { return this.warningCount; }
    getIsLocked()     { return this.isLocked; }
}

window.ExamLockMode = ExamLockMode;
