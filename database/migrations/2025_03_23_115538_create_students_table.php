<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'others'])->default('female')->nullable();
            $table->string('profile_picture')->nullable();
            $table->date('date_of_birth')->nullable();

            // // Verification fields
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('verification_code')->nullable();

            $table->string('location')->nullable();
            $table->text('home_address')->nullable();
            $table->string('department')->nullable();
            $table->json('guardians_ids')->nullable();
            $table->string('role')->default('student'); // Default role set to 'student'

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
