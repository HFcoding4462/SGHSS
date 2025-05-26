<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sexo;

class AddSexosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sexo::updateOrCreate(
            ['id' => Sexo::MASCULINO],
            ['descricao' => 'MASCULINO']
        );

        Sexo::updateOrCreate(
            ['id' => Sexo::FEMININO],
            ['descricao' => 'FEMININO']
        );

        Sexo::updateOrCreate(
            ['id' => Sexo::NAO_INFORMADO],
            ['descricao' => 'NAO INFORMADO']
        );
    }
}
