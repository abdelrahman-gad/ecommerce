<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::factory()->create([
            'username' => "admin@admin.com",
            'password' => Hash::make('password'),
            'name' => 'Abdelrahman Gad',
            'is_active' => true,
        ]);
    }
}
