<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Administrador', 'label' => 'ADMIN', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Tecnico', 'label' => 'TECN', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Professor', 'label' => 'PROF', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Aluno', 'label' => 'ALN', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
        ]);
    }
}
