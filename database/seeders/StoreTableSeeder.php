<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->insert([
            ['name' => 'SEDE', 'label' => 'SEDE', 'description' => 'Criado pelo sistema.', 'created_at' => Carbon::now() ],
          
        ]);
    }
}
