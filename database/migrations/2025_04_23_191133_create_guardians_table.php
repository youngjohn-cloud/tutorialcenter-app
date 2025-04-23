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
            $table->bigIncrements('guardian_id'); // Primary Key
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female', 'others'])->default('female')->nullable();
            $table->string('profile_picture')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable(); // consistent with Laravel's naming convention
            $table->string('location')->nullable();
            $table->text('home_address')->nullable(); // good as nullable
            $table->enum('status', ['active', 'inactive', 'disable'])->default('inactive')->nullable();
            $table->json('students_ids')->nullable(); // Typo 'studends_ids' corrected to 'students_ids'
            $table->softDeletes(); // Enables soft deletes
            $table->timestamps();  // Adds created_at and updated_at
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
