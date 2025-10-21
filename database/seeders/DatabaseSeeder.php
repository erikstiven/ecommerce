<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Option;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Contracts\Permission;

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
            'name' => 'Erik Stiven',
            'last_name' => 'Quisnia Tierra',
            'document_type' => 1, // Assuming 1 is a valid document type
            'document_number' => '0705871689',
            'email' => 'erikquisnia@gmail.com',
            'phone' => '0979018689',
            'password' => bcrypt('Nasa4036@'), // Password is hashed
        ]);

        \App\Models\User::factory(20)->create();


        $this->call(
            [
                PermissionSeeder::class,
                RoleSeeder::class,
                //FamilySeeder::class,                    // Add other seeders here if needed
                //OptionSeeder::class,
            ]
        );

        //Product::factory(150)->create();
    }
}
