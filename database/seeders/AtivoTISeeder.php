<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AtivoTI;

class AtivoTISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AtivoTI::factory()->count(5)->create();
    }
}
