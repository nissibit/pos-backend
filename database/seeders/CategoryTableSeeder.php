<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('categories')->insert([
            ['name' => 'Cosmeticos', 'label' => 'cosmeticos', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Higiene', 'label' => 'Higiene', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Limpeza', 'label' => 'limpeza', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Perfumes', 'label' => 'perfumes', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Sumos', 'label' => 'sumos', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            ['name' => 'Refrigerantes', 'label' => 'refrigerantes', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
            
        ]);
    }
}
