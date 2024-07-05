<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'jo@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        // category dummy 2
        Category::factory(2)->create();

        Product::factory(100)->create();
    }
}
