<?php

namespace App\Console\Commands;

use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Console\Command;
use Log;
use Throwable;

class DeleteUnverifiedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unverified-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {

            //threshold to track exact time user created an account in addition to the 24 hours countdown
            $threshold = now()->subHours(24);
    
            //task that deletes unverified students information after the 24 hours threshold
            $student = Student::whereNull('email_verified_at')->whereNull('phone_verified_at')->where('created_at', '<=', $threshold)->forceDelete();
    
            //task that deletes unverified guardians information after the 24 hours threshold
            $guardian = Guardian::whereNull('email_verified_at')->whereNull('phone_verified_at')->where('created_at', '<=', $threshold)->forceDelete();
    
            
            // Log::info("Deleted {$student} unverified students.");
            // Log::info("Deleted {$guardian} unverified guardians.");

        } catch (\Throwable $e) {
            
            //catches error found while carrying out task, displays it in the log file
            Log::error($e->getMessage());
        }
    }
}
