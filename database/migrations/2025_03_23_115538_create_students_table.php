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

            // Student Informations
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'others'])->default('female');
            $table->string('profile_picture')->nullable();
            $table->date('date_of_birth')->nullable();

            // // Verification fields
            $table->timestamp('email_verified')->nullable();
            $table->timestamp('phone_verified')->nullable();
            $table->boolean('verified')->default(false);

            //status
            $table->enum('status', ['online', 'away','offline', 'disable'])->default('offline');
            $table->string('location')->nullable();
            $table->text('home_address')->nullable();
            $table->string('department')->nullable();

            // Relationship to Guardian
            $table->json('guardians_ids')->nullable();

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