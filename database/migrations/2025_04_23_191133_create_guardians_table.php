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
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();

            // Guardian Informations
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');

            $table->enum('gender', ['Male', 'Female', 'Others'])->default('Female');
            $table->string('profile_picture')->nullable();
            $table->date('date_of_birth')->nullable();

            // Verification fields
            $table->string('email_verified_at')->nullable();
            $table->string('phone_verified_at')->nullable();
            $table->string('verification_code')->nullable();
            $table->boolean('verified')->default(false);

            //google login
            $table->string('google_id')->nullable()->unique();
            $table->string('provider')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'disable'])->default('inactive');
            $table->text('location')->nullable();  // (country, state)
            $table->text('home_address')->nullable();

            // Relationship to Student
            $table->json('students_ids')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
