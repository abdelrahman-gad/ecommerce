<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
       $product =  \App\Models\Product::factory()->create([
            'name' => 'Product 1',
            'description' => 'Product 1 description',
            'is_active' => true,
        ]);
   
       
        $product->prices()->createMany([
            [
                'user_type_id' => UserType::where('name', 'normal')->first()->id,
                'price' => 100,
            ],
            [
                'user_type_id' => UserType::where('name', 'silver')->first()->id,
                'price' => 90,
            ],
            [
                'user_type_id' => UserType::where('name', 'gold')->first()->id,
                'price' => 80,
            ],
        ]);

    }
}
