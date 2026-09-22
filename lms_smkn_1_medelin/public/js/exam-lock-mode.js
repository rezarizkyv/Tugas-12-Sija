/**
 * ExamLockMode - Anti-Cheat Detection System
 * 
 * Detects and tracks tab switching, window blur, and visibility changes
 * during exam sessions with tiered warning system and auto kick-out.
 */

class ExamLockMode {
    constructor(options = {}) {
        this.maxWarnings = options.maxWarnings || 3;
        this.onWarning = options.onWarning || (() => {});
        this.onLocked = options.onLocked || (() => {});
        
        this.warningCount = 0;
        this.isExamActive = false;
        this.isLocked = false;
        this.debounceTime = 500; // ms - prevent rapid re-triggers
        this.lastViolationTime = 0;
        
        this.setupEventListeners();
        
        console.log('✓ ExamLockMode initialized');
    }
    
    /**
     * Setup all event listeners for tab/window monitoring
     */
    setupEventListeners() {
        // Visibility Change (primary detection)
        document.addEventListener('visibilitychange', () => this.handleVisibilityChange());
        
        // Window Blur
        window.addEventListener('blur', () => this.handleBlur());
        
        // Page Hide
        window.addEventListener('pagehide', () => this.handlePageHide());
        
        // Try to prevent opening new tabs/windows
        document.addEventListener('keydown', (e) => this.handleKeyboardShortcut(e));
        
        // Disable right-click to prevent opening inspector/new tabs
        document.addEventListener('contextmenu', (e) => {
            if (this.isExamActive && !this.isLocked) {
                e.preventDefault();
                console.warn('⚠️ Right-click disabled during exam');
            }
        });
        
        // Monitor for developer tools (F12, Ctrl+Shift+I, etc.)
        this.monitorDeveloperTools();
    }
    
    /**
     * Handle visibility change (tab switch detection)
     */
    handleVisibilityChange() {
        if (!this.isExamActive || this.isLocked) return;
        
        if (document.hidden) {
            console.warn('⚠️ User switched away from exam tab');
            this.recordViolation('tab_switch');
        } else {
            console.log('✓ User returned to exam tab');
        }
    }
    
    /**
     * Handle window blur (focus loss)
     */
    handleBlur() {
        if (!this.isExamActive || this.isLocked) return;
        
        console.warn('⚠️ Window lost focus');
        this.recordViolation('window_blur');
    }
    
    /**
     * Handle page hide (unload/navigation)
     */
    handlePageHide() {
        if (!this.isExamActive || this.isLocked) return;
        
        console.warn('⚠️ Page is being hidden/unloaded');
        this.recordViolation('page_hide');
    }
    
    /**
     * Monitor keyboard shortcuts that could open dev tools or new windows
     */
    handleKeyboardShortcut(e) {
        if (!this.isExamActive || this.isLocked) return;
        
        const isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
        const cmdKey = isMac ? e.metaKey : e.ctrlKey;
        
        // Block common shortcuts
        const blockedShortcuts = {
            'F12': true,                    // Dev tools
            'I': e.shiftKey && cmdKey,     // Ctrl+Shift+I or Cmd+Option+I
            'J': e.shiftKey && cmdKey,     // Ctrl+Shift+J or Cmd+Option+J
            'C': e.shiftKey && cmdKey,     // Ctrl+Shift+C or Cmd+Option+C
            'N': cmdKey,                    // Ctrl+N or Cmd+N (new window)
            'T': cmdKey,                    // Ctrl+T or Cmd+T (new tab)
            'W': cmdKey,                    // Ctrl+W or Cmd+W (close tab)
        };
        
        if (blockedShortcuts[e.key] === true) {
            e.preventDefault();
            console.warn(`⚠️ Blocked keyboard shortcut: ${e.key}`);
            this.recordViolation('keyboard_shortcut');
        }
    }
    
    /**
     * Monitor developer tools opening (basic detection)
     */
    monitorDeveloperTools() {
        // This is a basic detection - not foolproof but provides some deterrent
        const threshold = 160; // pixels
        
        const checkDevTools = () => {
            if (!this.isExamActive || this.isLocked) return;
            
            // Check window size changes that might indicate dev tools
            const outerHeight = window.outerHeight;
            const innerHeight = window.innerHeight;
            const heightDiff = Math.abs(outerHeight - innerHeight);
            
            if (heightDiff > threshold) {
                console.warn('⚠️ Possible developer tools detected');
                this.recordViolation('dev_tools');
            }
        };
        
        // Check periodically during exam
        setInterval(checkDevTools, 2000);
    }
    
    /**
     * Record violation and trigger warning/kick
     */
    recordViolation(type) {
        // Debounce: prevent rapid-fire violations
        const now = Date.now();
        if (now - this.lastViolationTime < this.debounceTime) {
            return;
        }
        this.lastViolationTime = now;
        
        if (this.isLocked) return;
        
        this.warningCount++;
        
        console.log(`⚠️ VIOLATION #${this.warningCount} (${type})`);
        
        // Send violation data
        const violationData = {
            type: type,
            count: this.warningCount,
            timestamp: new Date().toISOString()
        };
        
        // Trigger callback for warning
        if (this.warningCount < this.maxWarnings) {
            this.onWarning(violationData);
        }
        
        // Trigger callback for locked (kicked out)
        if (this.warningCount >= this.maxWarnings) {
            this.lock(violationData);
        }
    }
    
    /**
     * Lock the exam (user kicked out)
     */
    lock(data) {
        if (this.isLocked) return;
        
        this.isLocked = true;
        console.error('🔒 EXAM LOCKED - Maximum warnings exceeded');
        
        // Disable further interactions
        this.setExamActive(false);
        
        // Trigger locked callback
        this.onLocked(data);
    }
    
    /**
     * Set exam active/inactive state
     */
    setExamActive(active) {
        this.isExamActive = active;
        console.log(`${active ? '▶️' : '⏹️'} Exam monitoring: ${active ? 'ACTIVE' : 'INACTIVE'}`);
    }
    
    /**
     * Reset violation counter (for new exam session)
     */
    reset() {
        this.warningCount = 0;
        this.isLocked = false;
        this.lastViolationTime = 0;
        console.log('🔄 ExamLockMode reset');
    }
    
    /**
     * Get current violation count
     */
    getWarningCount() {
        return this.warningCount;
    }
    
    /**
     * Check if exam is locked
     */
    getIsLocked() {
        return this.isLocked;
    }
}

// Make available globally
window.ExamLockMode = ExamLockMode;
