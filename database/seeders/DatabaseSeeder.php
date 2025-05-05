<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // Crear usuario cliente
        User::create([
            'name' => 'Cliente',
            'email' => 'cliente@example.com',
            'role' => 'client',
            'password' => Hash::make('password'),
        ]);

        // Crear algunas salas de ejemplo
        $rooms = [
            [
                'name' => 'Sala de Reuniones A',
                'description' => 'Sala amplia con capacidad para 10 personas, equipada con proyector y pizarra.',
            ],
            [
                'name' => 'Sala de Conferencias',
                'description' => 'Sala grande con capacidad para 20 personas, ideal para presentaciones y eventos.',
            ],
            [
                'name' => 'Oficina Privada 1',
                'description' => 'Oficina individual con escritorio, silla ergonómica y conexión a internet de alta velocidad.',
            ],
            [
                'name' => 'Espacio Colaborativo',
                'description' => 'Área abierta con mesas compartidas, ideal para trabajo en equipo y networking.',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}