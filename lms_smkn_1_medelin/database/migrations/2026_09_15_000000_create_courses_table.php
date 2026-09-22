<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('major'); // e.g., 'rpl', 'tkj'
            $table->string('code')->unique(); // e.g., 'RPL-XII-WEB'
            $table->string('title');
            $table->string('teacher');
            $table->integer('modules_count')->default(0);
            $table->integer('assignments_count')->default(0);
            $table->integer('progress')->default(0); // Optional default progress
            $table->string('icon')->default('book'); // FontAwesome icon name
            $table->string('color')->default('from-blue-600 to-indigo-700'); // Tailwind gradient
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
