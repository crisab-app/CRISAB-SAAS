<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear los roles de nuestro sistema
        $roleAdmin = Role::create(['name' => 'Super Administrador']);
        $rolePastor = Role::create(['name' => 'Pastor']);
        $roleLider = Role::create(['name' => 'Lider de Ministerio']);
        $roleMiembro = Role::create(['name' => 'Miembro']);

        // 2. Buscar tu usuario por correo y darle el rol de Super Administrador
        // ¡OJO! Cambia este correo por el tuyo real
        $adminUser = User::where('email', 'administrador@crisab.com')->first();

        if ($adminUser) {
            $adminUser->assignRole($roleAdmin);
        }
    }
}