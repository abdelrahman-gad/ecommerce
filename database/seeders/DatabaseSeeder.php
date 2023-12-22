<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

       $this->seedUserRecord();
       $this->seedAdmninRecord();
    }

    public function seedUserRecord(){
        \App\Models\User::factory()->create([
            'mobile' => "0123456789",
            'username' => "user@user.com",
            'password' => Hash::make('password'),
            'name' => 'Abdelrahman Gad',
            'mobile_verified_at' => now(),
            'is_active' => true,
            'avatar' => 'https://avatars.githubusercontent.com/u/18090930?v=4',
        ]);
    }

    public function seedAdmninRecord(){
        \App\Models\Admin::factory()->create([
            'username' => "admin@admin.com",
            'password' => Hash::make('password'),
            'name' => 'Abdelrahman Gad',
            'is_active' => true,
        ]);
    }

    public function seedUserTypeRecord(){

        $userTypes = [
            'normal',
            'silver',
            'gold',
        ];

        foreach ($userTypes as $userType) {
            \App\Models\UserType::factory()->create([
                'name' => $userType,
            ]);
        }
    }

}
