<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('locale', 5)->default('en_US');
            $table->string('full_name');
            $table->string('gender')->nullable();
            $table->timestamp('dob')->nullable();
            $table->string('anti_phishing_code', 20)->nullable();
            $table->string('email_token_confirmation', 36)->nullable();
            $table->string('email_token_disable_account', 36)->nullable();
            $table->boolean('google2fa_enable')->default(false);
            $table->string('google2fa_secret')->nullable();
            $table->text('google2fa_url')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
