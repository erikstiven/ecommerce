<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Limpia el caché de permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $driver = Role::firstOrCreate(['name' => 'driver', 'guard_name' => 'web']);

        // Asignar permisos al rol admin
        $admin->syncPermissions([
            'access dashboard',
            'manage options',
            'manage families',
            'manage categories',
            'manage subcategories',
            'manage products',
            'manage covers',
            'manage drivers',
            'manage orders',
            'manage shipments',
        ]);

        // Asignar permisos al rol driver
        $driver->syncPermissions([
            'access dashboard',
            'manage shipments',
        ]);

        // Buscar usuario por email (más confiable que ID)
        $user = User::where('email', 'erikquisnia@gmail.com')->first();

        if ($user) {
            $user->assignRole('admin');
            $this->command->info('✅ Usuario admin encontrado y rol asignado correctamente.');
        } else {
            $this->command->warn('⚠️ No se encontró el usuario con email erikquisnia@gmail.com.');
        }
    }
}
