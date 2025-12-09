<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('permissions')->insert([
//            #Menu
//            ['name' => 'menu_sell', 'label' => 'menu_sell', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_payment', 'label' => 'menu_payment', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_quotation', 'label' => 'menu_quotation', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_credit', 'label' => 'menu_credit', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_product', 'label' => 'menu_product', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_customer', 'label' => 'menu_customer', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_supplier', 'label' => 'menu_supplier', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_store', 'label' => 'menu_store', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_stock', 'label' => 'menu_stock', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            ['name' => 'menu_admin', 'label' => 'menu_admin', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            #product
//            ['name' => 'create_product', 'label' => 'create_product', 'description' => 'Criar produtos.', 'created_at' => Carbon::now()],
//            ['name' => 'show_product', 'label' => 'show_product', 'description' => 'Ver produtos.', 'created_at' => Carbon::now()],
//            ['name' => 'update_product', 'label' => 'edit_product', 'description' => 'Actualizar produtos.', 'created_at' => Carbon::now()],
//            ['name' => 'destroy_product', 'label' => 'destroy_product', 'description' => 'Suprimir produtos.', 'created_at' => Carbon::now()],
//            ['name' => 'delete_product', 'label' => 'delete_product', 'description' => 'Apagar produtos.', 'created_at' => Carbon::now()],
//            
//            ['name' => 'menu_admin', 'label' => 'menu_admin', 'description' => 'Ver menu das opções do utilizador.', 'created_at' => Carbon::now()],
//            #product
            ['name' => 'create_output', 'label' => 'create_output', 'description' => 'Criar produtos.', 'created_at' => Carbon::now()],
            ['name' => 'show_output', 'label' => 'show_output', 'description' => 'Ver produtos.', 'created_at' => Carbon::now()],
            ['name' => 'update_output', 'label' => 'edit_output', 'description' => 'Actualizar produtos.', 'created_at' => Carbon::now()],
            ['name' => 'destroy_output', 'label' => 'destroy_output', 'description' => 'Suprimir produtos.', 'created_at' => Carbon::now()],
            ['name' => 'delete_output', 'label' => 'delete_output', 'description' => 'Apagar produtos.', 'created_at' => Carbon::now()],
            
        ]);
    }

}
