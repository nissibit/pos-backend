<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UnityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unities')->insert([
            ['name' => 'Grama', 'label' => 'g', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Kilo', 'label' => 'Kg', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Litro', 'label' => 'LT', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],            
           
        ]);
    }
}
