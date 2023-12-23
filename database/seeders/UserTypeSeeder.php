<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    public function run(): void
    {
  
        $userTypes = [
            'normal',
            'silver',
            'gold',
        ];

        foreach ($userTypes as $userType) {
            \App\Models\UserType::firstOrCreate([
                'name' => $userType,
            ]);
        }
    }
}
