<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_violations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->unsignedBigInteger('student_id')->nullable(); // For future user tracking
            $table->string('violation_type'); // 'tab_switch', 'window_blur', 'page_hide', 'dev_tools', 'keyboard_shortcut'
            $table->integer('warning_count'); // Which warning # (1, 2, 3)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
            
            // Indexes for quick querying
            $table->index('quiz_id');
            $table->index('student_id');
            $table->index('recorded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_violations');
    }
};
