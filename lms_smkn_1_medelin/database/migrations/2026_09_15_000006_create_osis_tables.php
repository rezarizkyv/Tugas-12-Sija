<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('osis_candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('candidate_number');
            $table->string('leader_name');
            $table->string('vice_name');
            $table->string('leader_class');
            $table->string('vice_class');
            $table->text('vision');
            $table->text('mission');
            $table->string('photo_path')->nullable();
            $table->integer('vote_count')->default(0);
            $table->timestamps();
        });

        Schema::create('osis_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('osis_candidates')->onDelete('cascade');
            $table->string('vote_token_hash');
            $table->timestamp('voted_at');
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('osis_votes');
        Schema::dropIfExists('osis_candidates');
    }
};
