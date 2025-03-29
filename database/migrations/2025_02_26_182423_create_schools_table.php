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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->enum('type', ['School', 'Institution', 'Others'])->default('School');
            $table->boolean('allow_mock')->default(false);
            $table->boolean('allow_mock_result')->default('true');
            $table->boolean('allow_live_result')->default('false');
            $table->boolean('allow_mock_review')->default(true);
            $table->boolean('server_is_up')->default(false);
            $table->text('lincense');
            $table->foreignId('user_id')->cascade()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
