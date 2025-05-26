<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserRole;

class AddRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserRole::updateOrCreate(
            ['id' => UserRole::ADMINISTRADOR],
            ['descricao' => 'ADMINISTRADOR'],
        );

        UserRole::updateOrCreate(
            ['id' => UserRole::MEDICO],
            ['descricao' => 'MEDICO'],
        );

        UserRole::updateOrCreate(
            ['id' => UserRole::PACIENTE],
            ['descricao' => 'PACIENTE'],
        );
    }
}
