<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel exam_sessions menyimpan satu baris per sesi ujian siswa.
 * Data inilah yang ditampilkan di dashboard admin CBT.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exam_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Status sesi ujian
            $table->enum('status', [
                'in_progress',       // sedang mengerjakan
                'completed',         // selesai normal
                'auto_submitted',    // dikumpulkan otomatis karena pelanggaran
                'timeout',           // waktu habis
            ])->default('in_progress');

            // Jawaban disimpan sebagai JSON: {"0":"A","1":"C",...}
            $table->json('answers')->nullable();

            // Hasil grading
            $table->float('score')->nullable();
            $table->integer('correct_count')->nullable();
            $table->integer('total_questions')->nullable();

            // Tracking pelanggaran
            $table->integer('violation_count')->default(0);

            // Waktu
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('submitted_at')->nullable();

            // Meta
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('submit_reason')->nullable(); // 'manual', 'auto_violation', 'timeout'

            $table->timestamps();

            // Composite index agar query admin cepat
            $table->index(['quiz_id', 'user_id']);
            $table->index(['quiz_id', 'status']);
            $table->index('started_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_sessions');
    }
};

