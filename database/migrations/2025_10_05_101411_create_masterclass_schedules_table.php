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
        Schema::create('masterclass_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masterclass_id')->constrained('masterclasses')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['upcoming', 'ongoing', 'completed'])->default('upcoming');
            $table->date('day'); // date of class
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('staffs')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('staffs')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masterclass_schedules');
    }
};
