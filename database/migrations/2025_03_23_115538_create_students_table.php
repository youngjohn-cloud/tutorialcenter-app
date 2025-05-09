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

            // Verification fields
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('phone_verification_code')->nullable(); // <- Add this line
            $table->boolean('is_phone_verified')->default(false);   // <- Add this line

            $table->string('location')->nullable();
            $table->text('home_address')->nullable();
            $table->string('department')->nullable();
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


// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('students', function (Blueprint $table) {
//             $table->id('student_id');
//             $table->string('firstname');
//             $table->string('lastname');
//             $table->string('email')->unique()->nullable();
//             $table->string('phone')->unique()->nullable();
//             $table->string('password');
//             $table->enum('gender', ['male', 'female', 'others'])->default('female')->nullable();
//             $table->string('profile_picture')->nullable();
//             $table->date('date_of_birth')->nullable();
//             $table->timestamp('email_verified_at')->nullable();
//             $table->timestamp('phone_verified_at')->nullable(); // renamed and set as timestamp
//             $table->string('location')->nullable();
//             $table->text('home_address')->nullable(); // made nullable
//             $table->string('department')->nullable();
//             $table->json('guardians_ids')->nullable();
//             $table->softDeletes();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('students');
//     }
// };
