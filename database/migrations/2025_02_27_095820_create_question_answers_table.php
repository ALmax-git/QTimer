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
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_correct')->default(0)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->cascade();
            $table->unsignedBigInteger('exam_id')->nullable()->cascade();
            $table->unsignedBigInteger('question_id')->nullable()->cascade();
            $table->unsignedBigInteger('option_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_answers');
    }
};
