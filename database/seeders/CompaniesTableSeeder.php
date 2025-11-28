<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CompaniesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('companies')->insert([
            [
                'name' => 'Nisi Bit',
                'foto' => '',
                'tel' => '258845072912',
                'fax' => '',
                'email' => 'nissibit@gmail.com',
                'website' => 'http://www.nissibit.tech',
                'otherPhone' => '258829681455',
                'address' => 'Bairro Ferroviario, Q.54, C.201',
                'description' => 'Empresa de Tecnologias',                
                'init' => Carbon::now(),
            ],
        ]);
    }

}
