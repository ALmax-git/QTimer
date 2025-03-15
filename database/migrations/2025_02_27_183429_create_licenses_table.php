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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->longText('certificate');
            $table->unsignedBigInteger('user_id')->nullable(); // Owner of the license 
            $table->unsignedBigInteger('client_id')->nullable(); // Owner of the license 
            $table->enum('ownership', ['single', 'multiple'])->default('single'); //client can buy software for all user onder san client_id
            $table->unsignedBigInteger('software_id')->nullable(); // Software of the license (nullable if global)
            $table->text('key')->unique();                  // The license key
            $table->enum('license_type', ['trial', 'subscription', 'lifetime'])->default('trial'); // License type
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->integer('max_devices')->nullable();         // Maximum devices allowed for activation (null or 0 means unlimited)
            $table->json('activated_devices')->nullable();      // Stores an array of device IDs
            $table->timestamp('activated_at')->nullable();      // First activation timestamp
            $table->timestamp('expires_at')->nullable();          // Expiration date (null for lifetime)
            $table->boolean('is_active')->default(true);          // Overall license status
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
