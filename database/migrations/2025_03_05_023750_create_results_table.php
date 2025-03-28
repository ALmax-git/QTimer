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
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('progress');
            $table->time('started_at')->nullable();
            $table->time('submitted_at')->nullable();
            $table->time('last_seen_at')->nullable();
            $table->integer('result')->nullable()->index();
            $table->integer('total_question_count')->default(0);
            $table->integer('attempt_question_count')->default(0);
            $table->integer('time_spent')->nullable()->index();
            $table->foreignId('user_id')->nullable()->cascade();
            $table->foreignId('exam_id')->nullable()->cascade();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
