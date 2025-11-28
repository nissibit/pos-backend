<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Administrator',
                'username' => 'adminissi',
                'email' =>'admin@nissibit.tech',
                'password' => bcrypt("administrador"),
                'created_at' => Carbon::now()
            ],
            [
            'name' => 'Tecnico',
            'username' => 'tecnico',
            'email' =>'tecnico@nissibit.tech',
            'password' => bcrypt("tecnico"),
            'created_at' => Carbon::now()
            ],
          
        ]);
        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1],
            ['role_id' => 2, 'user_id' => 2]
        ]);
    }
}
