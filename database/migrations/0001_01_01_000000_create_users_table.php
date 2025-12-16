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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Default Breeze / Laravel auth columns
            $table->string('name')->nullable();          // user_name
            $table->string('email')->unique();           // user_email
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');                  // user_password

            // EXTRA PROFILE FIELDS (for My Profile page)
            $table->string('user_matric_id')->nullable();
            $table->string('user_phone_num')->nullable();
            $table->string('user_program')->nullable();
            $table->string('user_faculty')->nullable();
            $table->string('user_location')->nullable();

            // store image path/filename, e.g. "users/avatar.jpg"
            $table->string('user_profile_picture')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop in reverse order
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
