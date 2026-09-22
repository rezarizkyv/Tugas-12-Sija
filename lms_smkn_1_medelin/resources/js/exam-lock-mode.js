/**
 * Exam Lock Mode - Proctoring System
 * Detects tab switching and window blur to prevent cheating during exams
 * ⚠️ WARNING: Made AGGRESSIVE - Cannot dismiss, auto-kicks after 3 warnings
 */

class ExamLockMode {
  constructor(options = {}) {
    this.maxWarnings = options.maxWarnings || 3;
    this.warningCount = 0;
    this.isLocked = false;
    this.examActive = false;
    this.onWarning = options.onWarning || null;
    this.onLocked = options.onLocked || null;
    this.violations = [];
    this.warningTimeout = null;
    this.lastViolationTime = null;
    
    this.init();
  }

  init() {
    // Detect visibility change (tab switch) - VERY SENSITIVE
    document.addEventListener('visibilitychange', () => this.handleVisibilityChange());
    
    // Detect window blur (alt+tab, minimize, etc)
    window.addEventListener('blur', () => this.handleWindowBlur());
    window.addEventListener('focus', () => this.handleWindowFocus());
    
    // Prevent right-click (optional security measure)
    document.addEventListener('contextmenu', (e) => {
      if (this.examActive) e.preventDefault();
    });

    // Prevent keyboard shortcuts for opening devtools/new tab
    document.addEventListener('keydown', (e) => {
      if (!this.examActive) return;
      
      // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (DevTools)
      if (e.key === 'F12' || 
          (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) ||
          (e.ctrlKey && e.key === 't')) { // Ctrl+T (new tab)
        e.preventDefault();
      }
    });

    console.log('🔒 Exam Lock Mode initialized - AGGRESSIVE MODE');
  }

  handleVisibilityChange() {
    if (!this.examActive || this.isLocked) return;

    if (document.hidden) {
      // User switched away from tab
      this.recordViolation('Tab Switch Detected', 'User switched to another tab');
      this.triggerWarning();
    } else {
      // User returned to tab - but warning stays
      console.log('ℹ️ User returned to exam window');
    }
  }

  handleWindowBlur() {
    if (!this.examActive || this.isLocked) return;

    // Small delay to avoid false positives when clicking within the window
    setTimeout(() => {
      if (document.hidden) {
        this.recordViolation('Window Blur Detected', 'User minimized or switched window');
        this.triggerWarning();
      }
    }, 100);
  }

  handleWindowFocus() {
    // Just for tracking
    if (this.examActive && document.hidden === false) {
      console.log('✓ User returned to exam window');
    }
  }

  triggerWarning() {
    if (this.isLocked) return;

    this.warningCount++;
    this.lastViolationTime = new Date();
    
    console.warn(`⚠️ WARNING #${this.warningCount}/${this.maxWarnings}`);
    
    if (this.onWarning) {
      this.onWarning({
        count: this.warningCount,
        remaining: this.maxWarnings - this.warningCount
      });
    }

    // 🔒 LOCK EXAM if max warnings exceeded
    if (this.warningCount >= this.maxWarnings) {
      this.lockExam();
    }
  }

  lockExam() {
    this.isLocked = true;
    this.examActive = false;
    
    console.error('🔒 EXAM LOCKED - User exceeded maximum warnings');
    
    if (this.onLocked) {
      this.onLocked({
        violationCount: this.warningCount,
        violations: this.violations
      });
    }
  }

  recordViolation(type, description) {
    const violation = {
      type,
      description,
      timestamp: new Date().toISOString(),
      warningNumber: this.warningCount + 1
    };
    
    this.violations.push(violation);
    console.warn(`📝 Violation recorded: ${type}`, violation);
  }

  setExamActive(active) {
    this.examActive = active;
    
    if (active) {
      console.log('✅ Exam lock mode ENABLED - AGGRESSIVE');
      this.warningCount = 0;
      this.isLocked = false;
      this.violations = [];
      this.lastViolationTime = null;
    } else {
      console.log('❌ Exam lock mode DISABLED');
    }
  }

  getStatus() {
    return {
      examActive: this.examActive,
      isLocked: this.isLocked,
      warningCount: this.warningCount,
      maxWarnings: this.maxWarnings,
      violations: this.violations
    };
  }

  reset() {
    this.warningCount = 0;
    this.isLocked = false;
    this.examActive = false;
    this.violations = [];
    this.lastViolationTime = null;
    console.log('🔄 Exam lock mode reset');
  }

  // Force lock after X seconds of inactivity
  startIdleTimer(seconds = 30) {
    if (this.idleTimer) clearTimeout(this.idleTimer);
    
    let idleTime = 0;
    const checkInterval = setInterval(() => {
      if (!this.examActive) {
        clearInterval(checkInterval);
        return;
      }
      
      idleTime++;
      if (idleTime >= seconds) {
        this.triggerWarning();
        idleTime = 0;
      }
    }, 1000);
    
    this.idleTimer = checkInterval;
  }
}

// Export for use in Blade templates
window.ExamLockMode = ExamLockMode;

