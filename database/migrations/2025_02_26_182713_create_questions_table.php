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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->longText('text')->index();
            $table->longText('code_snippet')->nullable()->index();
            $table->longText('answer_explanation')->nullable()->index();
            $table->string('image')->nullable();
            $table->string('more_info_link')->nullable()->index();
            $table->foreignId('subject_id')->nullable()->cascade();
            $table->enum('status', ['active', 'in-active'])->default('active');
            $table->enum('type', ['objective', 'essay'])->default('objective');
            $table->integer('max_response')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
