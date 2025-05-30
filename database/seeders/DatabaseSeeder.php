<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Storage::deleteDirectory('products'); // Clear the products directory before seeding
        Storage::makeDirectory('products'); // Create the products directory
        // User::factory(10)->create();

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        //crear un usuario administrador
        \App\Models\User::factory()->create([
            'name' => 'Erik Quisnia',
            'email' => 'erikquisnia@gmail.com',
            'password' => bcrypt('Nasa4036'), // Password is hashed
        ]);

        $this->call(
            [
                FamilySeeder::class,                    // Add other seeders here if needed
            ]
        );

        Product::factory(150)->create();
    }
}
