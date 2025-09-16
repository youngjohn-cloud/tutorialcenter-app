<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 10 random staff
        Staff::factory()->count(10)->create();
    }
}
