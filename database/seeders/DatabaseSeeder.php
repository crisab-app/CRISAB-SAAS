<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Master System',
            'email' => 'enriquealfredotorreslorenzana@gmail.com', // Cambia esto por tu correo real de administrador
            'password' => Hash::make('SaasAdmin2026'), // Pon una contraseña fuerte
            'is_super_admin' => true, // 🚨 EL PASE VIP
            'contract_id' => null, // 👻 FANTASMA: No pertenece a ninguna iglesia (Asegúrate de que tu contract_id permita null en la BD)
            'email_verified_at' => now(),
        ]);
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
